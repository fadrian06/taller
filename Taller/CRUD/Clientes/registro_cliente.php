<?php
require_once '../../config/Database.php';

class ClientValidator
{
    private $errors = [];

    public function validateForm($data)
    {
        // Validar nombres y apellidos
        $nameRegex = "/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}$/";

        if (!preg_match($nameRegex, $data['firstName'])) {
            $this->errors[] = "El primer nombre debe comenzar con mayúscula y contener solo letras";
        }

        if (!empty($data['secondName']) && !preg_match($nameRegex, $data['secondName'])) {
            $this->errors[] = "El segundo nombre debe comenzar con mayúscula y contener solo letras";
        }

        if (!preg_match($nameRegex, $data['firstSurname'])) {
            $this->errors[] = "El primer apellido debe comenzar con mayúscula y contener solo letras";
        }

        if (!empty($data['secondSurname']) && !preg_match($nameRegex, $data['secondSurname'])) {
            $this->errors[] = "El segundo apellido debe comenzar con mayúscula y contener solo letras";
        }

        // Validar cédula
        if (!preg_match("/^[VE]-\d{6,8}$/", $data['cedula'])) {
            $this->errors[] = "Formato de cédula inválido (debe ser V-XXXXXXXX o E-XXXXXXXX)";
        }

        // Validar teléfonos
        $phoneRegex = "/^\d{11}$/";
        if (!preg_match($phoneRegex, $data['personalPhone'])) {
            $this->errors[] = "El teléfono personal debe contener 11 dígitos";
        }

        if (!empty($data['landlinePhone']) && !preg_match($phoneRegex, $data['landlinePhone'])) {
            $this->errors[] = "El teléfono fijo debe contener 11 dígitos";
        }

        if (!empty($data['optionalPhone']) && !preg_match($phoneRegex, $data['optionalPhone'])) {
            $this->errors[] = "El teléfono opcional debe contener 11 dígitos";
        }

        // Validar dirección
        $locationRegex = "/^[A-ZÁÉÍÓÚ][a-záéíóúñ\s]*$/";
        if (!preg_match($locationRegex, $data['state'])) {
            $this->errors[] = "Estado inválido";
        }

        if (!preg_match($locationRegex, $data['municipality'])) {
            $this->errors[] = "Municipio inválido";
        }

        if (!preg_match($locationRegex, $data['parish'])) {
            $this->errors[] = "Parroquia inválida";
        }

        $streetRegex = "/^[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s\-]{1,49}$/";
        if (!preg_match($streetRegex, $data['avenue'])) {
            $this->errors[] = "Avenida inválida";
        }

        if (!preg_match($streetRegex, $data['street'])) {
            $this->errors[] = "Calle inválida";
        }

        $houseRegex = "/^[A-ZÁÉÍÓÚ][a-záéíóúñ0-9\s#\-]{1,49}$/";
        if (!preg_match($houseRegex, $data['houseOrApartment'])) {
            $this->errors[] = "Casa/Apartamento inválido";
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

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
            $casaApartamentoId = $this->getOrCreateId('CasasApartamentos', 'casaApartamentoId', 'detalleCasaApartamento', $data['houseOrApartment'], 'calleId', $calleId);

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
            throw new Exception("Error procesando $table: " . $e->getMessage());
        }
    }
}

// Manejar la solicitud
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration = new ClientRegistration();
    $result = $registration->register($_POST);
    echo json_encode($result);
    exit;
}