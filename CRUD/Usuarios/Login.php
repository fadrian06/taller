<?php
// Incluir la clase de conexión
require_once '../../config/Database.php';

// Clase LoginController para gestionar el inicio de sesión
class LoginController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function iniciarSesion($nombreUsuario, $contrasena)
    {
        try {
            // Consulta para obtener los datos del usuario, incluyendo información personal y de contacto
            $query = "
                SELECT u.cedula, u.nombreUsuario, u.contrasena, r.nombreRol,
                d.primerNombre, d.segundoNombre, d.primerApellido, d.segundoApellido,
                c.telefono, c.correo
                FROM Usuarios u
                JOIN RolUsuario r ON u.idRol = r.idRol
                JOIN DatosUsuario d ON u.cedula = d.cedula
                JOIN ContactosUsuario c ON u.cedula = c.cedula
                WHERE u.nombreUsuario = ?
            ";

            $stmt = $this->db->prepare($query);
            $stmt->execute([$nombreUsuario]);

            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificar la contraseña usando password_verify
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    // Inicio de sesión exitoso
                    return [
                        'success' => true,
                        'message' => 'Inicio de sesión exitoso.',
                        'user' => [
                            'cedula' => $usuario['cedula'],
                            'nombreUsuario' => $usuario['nombreUsuario'],
                            'rol' => $usuario['nombreRol'],
                            'primerNombre' => $usuario['primerNombre'],
                            'segundoNombre' => $usuario['segundoNombre'],
                            'primerApellido' => $usuario['primerApellido'],
                            'segundoApellido' => $usuario['segundoApellido'],
                            'telefono' => $usuario['telefono'],
                            'correo' => $usuario['correo']
                        ]
                    ];
                } else {
                    // Contraseña incorrecta
                    return [
                        'success' => false,
                        'message' => 'Contraseña incorrecta.'
                    ];
                }
            } else {
                // Usuario no encontrado
                return [
                    'success' => false,
                    'message' => 'El usuario no existe.'
                ];
            }
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            return [
                'success' => false,
                'message' => 'Error al intentar iniciar sesión: ' . $e->getMessage()
            ];
        }
    }
}

// Procesar la solicitud del cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['username'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (!empty($nombreUsuario) && !empty($contrasena)) {
        $loginController = new LoginController();
        $resultado = $loginController->iniciarSesion($nombreUsuario, $contrasena);

        if ($resultado['success']) {
            // Iniciar sesión en PHP
            session_start();  // Inicia la sesión

            // Almacenar la información del usuario en las variables de sesión
            $_SESSION['usuario_logeado'] = $resultado['user']['cedula'];  // Guarda el ID del usuario
            $_SESSION['nombreUsuario'] = $resultado['user']['nombreUsuario'];  // Guarda el nombre de usuario
            $_SESSION['rol'] = $resultado['user']['rol'];  // Guarda el rol del usuario
            $_SESSION['primerNombre'] = $resultado['user']['primerNombre'];  // Guarda el primer nombre
            $_SESSION['segundoNombre'] = $resultado['user']['segundoNombre'];  // Guarda el segundo nombre
            $_SESSION['primerApellido'] = $resultado['user']['primerApellido'];  // Guarda el primer apellido
            $_SESSION['segundoApellido'] = $resultado['user']['segundoApellido'];  // Guarda el segundo apellido
            $_SESSION['telefono'] = $resultado['user']['telefono'];  // Guarda el teléfono
            $_SESSION['correo'] = $resultado['user']['correo'];  // Guarda el correo

            // Responder con un mensaje de éxito y redirigir al usuario
            echo json_encode([
                'success' => true,
                'message' => 'Inicio de sesión exitoso.',
            ]);
        } else {
            // Si las credenciales son incorrectas
            echo json_encode($resultado);  // Retornar el error
        }
    } else {
        // Respuesta en caso de datos incompletos
        echo json_encode([
            'success' => false,
            'message' => 'Por favor complete todos los campos.'
        ]);
    }
}
