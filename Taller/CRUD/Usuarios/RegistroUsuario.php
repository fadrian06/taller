<?php
// Incluir la clase Database para manejar la conexión
require_once '../../config/Database.php';

// Clase para validar los datos del usuario
class UserValidator {
    private $errors = []; // Array para almacenar los errores

    // Método para validar el formulario
    public function validateForm($data) {
        // Validar nombres
        $nameRegex = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,30}$/";
        if (!preg_match($nameRegex, $data['firstName'])) {
            $this->errors[] = "Primer nombre inválido";
        }
        if ($data['secondName'] && !preg_match($nameRegex, $data['secondName'])) {
            $this->errors[] = "Segundo nombre inválido";
        }
        if (!preg_match($nameRegex, $data['firstSurname'])) {
            $this->errors[] = "Primer apellido inválido";
        }
        if ($data['secondSurname'] && !preg_match($nameRegex, $data['secondSurname'])) {
            $this->errors[] = "Segundo apellido inválido";
        }

        // Validar cédula
        if (!preg_match("/^[V|E]-\d{5,8}$/", $data['cedula'])) {
            $this->errors[] = "Cédula inválida";
        }

        // Validar teléfono
        if (!preg_match("/^\d{11}$/", $data['phone'])) {
            $this->errors[] = "Teléfono inválido";
        }

        // Validar correo electrónico
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Correo electrónico inválido";
        }

        // Validar nombre de usuario
        if (!preg_match("/^[a-zA-Z0-9_]{4,20}$/", $data['username'])) {
            $this->errors[] = "Nombre de usuario inválido";
        }

        // Validar contraseña
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/", $data['password'])) {
            $this->errors[] = "Contraseña inválida";
        }

        // Devolver verdadero si no hay errores
        return empty($this->errors);
    }

    // Método para obtener los errores
    public function getErrors() {
        return $this->errors;
    }
}

// Clase para manejar el registro de usuarios
class UserRegistration {
    private $conn; // Conexión a la base de datos
    private $validator; // Instancia del validador

    public function __construct() {
        $database = new Database(); // Crear instancia de Database
        $this->conn = $database->getConnection(); // Obtener conexión
        $this->validator = new UserValidator(); // Instanciar el validador
    }

    // Método para registrar un usuario
    public function register($data) {
        // Validar los datos del formulario
        if (!$this->validator->validateForm($data)) {
            return [
                'success' => false,
                'errores' => $this->validator->getErrors()
            ];
        }

        try {
            $this->conn->beginTransaction(); // Iniciar una transacción

            // Obtener el ID del rol
            $stmt = $this->conn->prepare("SELECT idRol FROM RolUsuario WHERE nombreRol = ?");
            $stmt->execute([$data['role']]);
            $roleId = $stmt->fetchColumn();

            if (!$roleId) {
                throw new Exception("El rol especificado no existe.");
            }

            // Limpiar el formato de la cédula
            $cedula = str_replace(['V-', 'E-'], '', $data['cedula']);

            // Insertar en la tabla Usuarios
            $stmt = $this->conn->prepare(
                "INSERT INTO Usuarios (cedula, idRol, nombreUsuario, contrasena) VALUES (?, ?, ?, ?)"
            );
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->execute([$cedula, $roleId, $data['username'], $hashedPassword]);

            // Insertar en la tabla DatosUsuario
            $stmt = $this->conn->prepare(
                "INSERT INTO DatosUsuario (cedula, primerNombre, segundoNombre, primerApellido, segundoApellido) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $cedula,
                $data['firstName'],
                $data['secondName'],
                $data['firstSurname'],
                $data['secondSurname']
            ]);

            // Insertar en la tabla ContactosUsuario
            $stmt = $this->conn->prepare(
                "INSERT INTO ContactosUsuario (cedula, telefono, correo) VALUES (?, ?, ?)"
            );
            $stmt->execute([$cedula, $data['phone'], $data['email']]);

            $this->conn->commit(); // Confirmar la transacción
            return [
                'success' => true,
                'mensaje' => 'Usuario registrado exitosamente'
            ];
        } catch (PDOException $e) {
            $this->conn->rollBack(); // Revertir la transacción en caso de error
            return [
                'success' => false,
                'mensaje' => 'Error al registrar usuario: ' . $e->getMessage()
            ];
        }
    }
}

// Manejar la solicitud de registro
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration = new UserRegistration(); // Instanciar la clase de registro
    $result = $registration->register($_POST); // Registrar al usuario con los datos enviados
    echo json_encode($result); // Devolver la respuesta en formato JSON
    exit;
}
