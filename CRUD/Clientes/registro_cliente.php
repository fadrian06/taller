<?php

require_once '../../config/Database.php';
require_once __DIR__ . '/ClientValidator.php';

class ClientRegistration
{
    private $conn;
    private $validator;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->validator = new ClientValidator();
    }

    public function register($data)
    {
        if (!$this->validator->validateForm($data)) {
            return [
                'success' => false,
                'mensaje' => implode(", ", $this->validator->getErrors())
            ];
        }

        try {
            $this->conn->beginTransaction();

            // Procesar la dirección (insertando o recuperando IDs en orden)
            $estadoId = $this->getOrCreateId('Estados', 'estadoId', 'nombreEstado', $data['state']);
            $municipioId = $this->getOrCreateId('Municipios', 'municipioId', 'nombreMunicipio', $data['municipality'], 'estadoId', $estadoId);
            $parroquiaId = $this->getOrCreateId('Parroquias', 'parroquiaId', 'nombreParroquia', $data['parish'], 'municipioId', $municipioId);
            $avenidaId = $this->getOrCreateId('Avenidas', 'avenidaId', 'nombreAvenida', $data['avenue'], 'parroquiaId', $parroquiaId);
            $calleId = $this->getOrCreateId('Calles', 'calleId', 'nombreCalle', $data['street'], 'avenidaId', $avenidaId);
            // TODO: add housingType in `CasasApartamentos` table
            $casaApartamentoId = $this->getOrCreateId('CasasApartamentos', 'casaApartamentoId', 'detalleCasaApartamento', $data['housingNumber'], 'calleId', $calleId);

            // Limpiar la cédula
            $cedula = str_replace(['V-', 'E-'], '', $data['cedula']);

            // Insertar cliente
            $stmt = $this->conn->prepare(
                "INSERT INTO Clientes (cedula, primerNombre, segundoNombre, primerApellido, segundoApellido) 
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $cedula,
                $data['firstName'],
                $data['secondName'] ?: null,
                $data['firstSurname'],
                $data['secondSurname'] ?: null
            ]);

            // Insertar teléfonos
            $stmt = $this->conn->prepare(
                "INSERT INTO Telefonos (cedulaCliente, telefonoPersonal, telefonoFijo, telefonoOpcional) 
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $cedula,
                $data['personalPhone'],
                $data['landlinePhone'] ?: null,
                $data['optionalPhone'] ?: null
            ]);

            // Insertar dirección
            $stmt = $this->conn->prepare(
                "INSERT INTO Direcciones (cedulaCliente, casaApartamentoId) 
                 VALUES (?, ?)"
            );
            $stmt->execute([$cedula, $casaApartamentoId]);

            $this->conn->commit();
            return [
                'success' => true,
                'mensaje' => 'Cliente registrado exitosamente'
            ];
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return [
                'success' => false,
                'mensaje' => 'Error al registrar cliente: ' . $e->getMessage()
            ];
        }
    }

    private function getOrCreateId($table, $idColumn, $nameColumn, $value, $parentIdColumn = null, $parentId = null)
    {
        try {
            // Preparar la consulta según si tiene o no padre
            if ($parentIdColumn) {
                $stmt = $this->conn->prepare(
                    "SELECT $idColumn FROM $table 
                     WHERE $nameColumn = ? AND $parentIdColumn = ?"
                );
                $stmt->execute([$value, $parentId]);
            } else {
                $stmt = $this->conn->prepare(
                    "SELECT $idColumn FROM $table 
                     WHERE $nameColumn = ?"
                );
                $stmt->execute([$value]);
            }

            $id = $stmt->fetchColumn();

            // Si no existe, insertar
            if (!$id) {
                if ($parentIdColumn) {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO $table ($nameColumn, $parentIdColumn) 
                         VALUES (?, ?)"
                    );
                    $stmt->execute([$value, $parentId]);
                } else {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO $table ($nameColumn) 
                         VALUES (?)"
                    );
                    $stmt->execute([$value]);
                }
                $id = $this->conn->lastInsertId();
            }

            return $id;
        } catch (PDOException $e) {
            exit("Error procesando $table: " . $e->getMessage());
        }
    }
}

// Manejar la solicitud
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration = new ClientRegistration();
    $result = $registration->register($_POST);

    exit(json_encode($result));
}
