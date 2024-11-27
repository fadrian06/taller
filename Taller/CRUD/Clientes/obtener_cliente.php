<?php
require_once "../../config/Database.php";

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    try {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "SELECT 
                    c.cedula,
                    c.primerNombre,
                    c.segundoNombre,
                    c.primerApellido,
                    c.segundoApellido,
                    t.telefonoPersonal,
                    t.telefonoFijo,
                    t.telefonoOpcional,
                    e.nombreEstado AS estado,
                    m.nombreMunicipio AS municipio,
                    p.nombreParroquia AS parroquia,
                    av.nombreAvenida AS avenida,
                    cl.nombreCalle AS calle,
                    ca.detalleCasaApartamento AS casaApartamento
                FROM Clientes c
                JOIN Telefonos t ON c.cedula = t.cedulaCliente
                JOIN Direcciones d ON c.cedula = d.cedulaCliente
                JOIN CasasApartamentos ca ON d.casaApartamentoId = ca.casaApartamentoId
                JOIN Calles cl ON ca.calleId = cl.calleId
                JOIN Avenidas av ON cl.avenidaId = av.avenidaId
                JOIN Parroquias p ON av.parroquiaId = p.parroquiaId
                JOIN Municipios m ON p.municipioId = m.municipioId
                JOIN Estados e ON m.estadoId = e.estadoId
                WHERE c.cedula = :cedula";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'cliente' => $cliente]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cliente no encontrado']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Cédula no proporcionada']);
}
