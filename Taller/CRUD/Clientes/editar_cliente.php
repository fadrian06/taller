<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../config/Database.php';

class ClientValidator {
    private $errors = [];

    public function validateForm($data) {
        // Verificar campos requeridos
        $requiredFields = ['firstName', 'firstSurname', 'cedula', 'personalPhone', 
                          'state', 'municipality', 'parish', 'avenue', 'street', 'houseOrApartment'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $this->errors[] = "El campo " . $field . " es requerido";
                return false;
            }
        }

        // Validaciones de formato
        $nameRegex = "/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{1,29}$/u";
        if (!preg_match($nameRegex, trim($data['firstName']))) {
            $this->errors[] = "Primer nombre inválido";
        }
        if (!empty($data['secondName']) && !preg_match($nameRegex, trim($data['secondName']))) {
            $this->errors[] = "Segundo nombre inválido";
        }
        if (!preg_match($nameRegex, trim($data['firstSurname']))) {
            $this->errors[] = "Primer apellido inválido";
        }
        if (!empty($data['secondSurname']) && !preg_match($nameRegex, trim($data['secondSurname']))) {
            $this->errors[] = "Segundo apellido inválido";
        }

        // Validar teléfonos
        if (!preg_match("/^\d{11}$/", trim($data['personalPhone']))) {
            $this->errors[] = "Teléfono personal inválido";
        }
        if (!empty($data['landlinePhone']) && !preg_match("/^\d{11}$/", trim($data['landlinePhone']))) {
            $this->errors[] = "Teléfono fijo inválido";
        }
        if (!empty($data['optionalPhone']) && !preg_match("/^\d{11}$/", trim($data['optionalPhone']))) {
            $this->errors[] = "Teléfono opcional inválido";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}

class ClientUpdate {
    private $conn;
    private $validator;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->validator = new ClientValidator();
    }

    public function update($data) {
        if (!$this->validator->validateForm($data)) {
            return [
                'success' => false,
                'mensaje' => implode(", ", $this->validator->getErrors())
            ];
        }

        try {
            $this->conn->beginTransaction();

            $cedula = str_replace(['V-', 'E-'], '', $data['cedula']);
            
            // Verificar si el cliente existe
            $stmt = $this->conn->prepare("SELECT cedula FROM Clientes WHERE cedula = ?");
            $stmt->execute([$cedula]);
            if (!$stmt->fetchColumn()) {
                throw new Exception("No existe un cliente con esta cédula");
            }

            // Actualizar datos del cliente
            $stmt = $this->conn->prepare(
                "UPDATE Clientes 
                 SET primerNombre = ?, 
                     segundoNombre = ?, 
                     primerApellido = ?, 
                     segundoApellido = ?
                 WHERE cedula = ?"
            );
            $stmt->execute([
                trim($data['firstName']),
                !empty($data['secondName']) ? trim($data['secondName']) : null,
                trim($data['firstSurname']),
                !empty($data['secondSurname']) ? trim($data['secondSurname']) : null,
                $cedula
            ]);

            // Actualizar teléfonos
            $stmt = $this->conn->prepare(
                "UPDATE Telefonos 
                 SET telefonoPersonal = ?, 
                     telefonoFijo = ?, 
                     telefonoOpcional = ?
                 WHERE cedulaCliente = ?"
            );
            $stmt->execute([
                trim($data['personalPhone']),
                !empty($data['landlinePhone']) ? trim($data['landlinePhone']) : null,
                !empty($data['optionalPhone']) ? trim($data['optionalPhone']) : null,
                $cedula
            ]);

            // Actualizar dirección - Primero obtener los IDs existentes
            $stmt = $this->conn->prepare("
                SELECT e.estadoId, m.municipioId, p.parroquiaId, a.avenidaId, c.calleId, ca.casaApartamentoId
                FROM Estados e
                JOIN Municipios m ON e.estadoId = m.estadoId
                JOIN Parroquias p ON m.municipioId = p.municipioId
                JOIN Avenidas a ON p.parroquiaId = a.parroquiaId
                JOIN Calles c ON a.avenidaId = c.avenidaId
                JOIN CasasApartamentos ca ON c.calleId = ca.calleId
                JOIN Direcciones d ON ca.casaApartamentoId = d.casaApartamentoId
                WHERE d.cedulaCliente = ?
            ");
            $stmt->execute([$cedula]);
            $locationIds = $stmt->fetch(PDO::FETCH_ASSOC);

            // Actualizar cada nivel de la dirección
            $this->updateLocation(
                'Estados', 'estadoId', 'nombreEstado', 
                $locationIds['estadoId'], $data['state']
            );

            $this->updateLocation(
                'Municipios', 'municipioId', 'nombreMunicipio', 
                $locationIds['municipioId'], $data['municipality']
            );

            $this->updateLocation(
                'Parroquias', 'parroquiaId', 'nombreParroquia', 
                $locationIds['parroquiaId'], $data['parish']
            );

            $this->updateLocation(
                'Avenidas', 'avenidaId', 'nombreAvenida', 
                $locationIds['avenidaId'], $data['avenue']
            );

            $this->updateLocation(
                'Calles', 'calleId', 'nombreCalle', 
                $locationIds['calleId'], $data['street']
            );

            $this->updateLocation(
                'CasasApartamentos', 'casaApartamentoId', 'detalleCasaApartamento', 
                $locationIds['casaApartamentoId'], $data['houseOrApartment']
            );

            $this->conn->commit();
            return [
                'success' => true,
                'mensaje' => 'Cliente actualizado exitosamente'
            ];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return [
                'success' => false,
                'mensaje' => 'Error al actualizar cliente: ' . $e->getMessage()
            ];
        }
    }

    private function updateLocation($table, $idColumn, $nameColumn, $id, $newValue) {
        $stmt = $this->conn->prepare(
            "UPDATE $table 
             SET $nameColumn = ?
             WHERE $idColumn = ?"
        );
        $stmt->execute([trim($newValue), $id]);
    }
}

// Manejo de la solicitud
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $clientUpdate = new ClientUpdate();
        $result = $clientUpdate->update($_POST);
        echo json_encode($result);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'Método no permitido'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}