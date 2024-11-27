<?php
require_once '../../config/Database.php';

class ClientDeletion {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function delete($cedula) {
        try {
            $this->conn->beginTransaction();

            // 1. Obtener el casaApartamentoId antes de eliminar la dirección
            $stmt = $this->conn->prepare("SELECT casaApartamentoId FROM Direcciones WHERE cedulaCliente = ?");
            $stmt->execute([$cedula]);
            $casaApartamentoId = $stmt->fetchColumn();

            // 2. Eliminar registro de la tabla Telefonos
            $stmt = $this->conn->prepare("DELETE FROM Telefonos WHERE cedulaCliente = ?");
            $stmt->execute([$cedula]);

            // 3. Eliminar registro de la tabla Direcciones
            $stmt = $this->conn->prepare("DELETE FROM Direcciones WHERE cedulaCliente = ?");
            $stmt->execute([$cedula]);

            // 4. Eliminar registro de la tabla Clientes
            $stmt = $this->conn->prepare("DELETE FROM Clientes WHERE cedula = ?");
            $stmt->execute([$cedula]);

            // 5. Confirmar la transacción
            $this->conn->commit();

            return [
                'success' => true,
                'mensaje' => '¡Cliente eliminado exitosamente!'
            ];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            return [
                'success' => false,
                'mensaje' => 'Error al eliminar cliente: ' . $e->getMessage()
            ];
        }
    }
}

// Asegurar que se envíe como JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cedula'])) {
    $deletion = new ClientDeletion();
    $cedula = str_replace(['V-', 'E-'], '', $_POST['cedula']);
    $result = $deletion->delete($cedula);
    echo json_encode($result);
    exit;
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Solicitud inválida'
    ]);
    exit;
}