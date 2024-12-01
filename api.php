<?php

require_once 'vendor/autoload.php';

$pdo = new PDO('sqlite:database/venezuela.db', options: [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

if (key_exists('estados', $_GET)) {
  $stmt = $pdo->query('
    SELECT *, SUBSTR(nombre, 0, 2) as inicial
    FROM estados ORDER BY inicial
  ');

  $iniciales = [];

  while ($estado = $stmt->fetch()) {
    $iniciales[$estado['inicial']][] = $estado;
  }

  exit(json_encode($iniciales));
}

if (key_exists('municipios', $_GET) && key_exists('id_estado', $_GET)) {
  $stmt = $pdo->prepare('
    SELECT *, SUBSTR(nombre, 0, 2) as inicial
    FROM municipios WHERE id_estado = ? ORDER BY inicial
  ');

  $stmt->execute([$_GET['id_estado']]);
  $iniciales = [];

  while ($municipio = $stmt->fetch()) {
    $iniciales[$municipio['inicial']][] = $municipio;
  }

  exit(json_encode($iniciales));
}

if (key_exists('parroquias', $_GET) && key_exists('id_municipio', $_GET)) {
  $stmt = $pdo->prepare('
    SELECT *, SUBSTR(nombre, 0, 2) as inicial
    FROM parroquias WHERE id_municipio = ? ORDER BY inicial
  ');

  $stmt->execute([$_GET['id_municipio']]);
  $iniciales = [];

  while ($parroquia = $stmt->fetch()) {
    $iniciales[$parroquia['inicial']][] = $parroquia;
  }

  exit(json_encode($iniciales));
}

if (key_exists('avenidas', $_GET) && key_exists('id_parroquia', $_GET)) {
  $stmt = $pdo->prepare('
    SELECT * FROM avenidas WHERE id_parroquia = ?
  ');

  $stmt->execute([$_GET['id_parroquia']]);

  exit(json_encode($stmt->fetchAll()));
}

if (key_exists('calles', $_GET) && key_exists('id_avenida', $_GET) && key_exists('id_parroquia', $_GET)) {
  $stmt = $pdo->prepare('
    SELECT * FROM calles
    WHERE id_avenida = :id_avenida OR id_parroquia = :id_parroquia
  ');

  $stmt->execute([
    ':id_avenida' => $_GET['id_avenida'],
    ':id_parroquia' => $_GET['id_parroquia']
  ]);

  exit(json_encode($stmt->fetchAll()));
}

if (key_exists('id_estado', $_GET)) {
  $stmt = $pdo->prepare('SELECT * FROM estados WHERE id = ?');
  $stmt->execute([$_GET['id_estado']]);

  exit(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
}

if (key_exists('id_municipio', $_GET)) {
  $stmt = $pdo->prepare('SELECT * FROM municipios WHERE id = ?');
  $stmt->execute([$_GET['id_municipio']]);

  exit(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
}

if (key_exists('id_parroquia', $_GET)) {
  $stmt = $pdo->prepare('SELECT * FROM parroquias WHERE id = ?');
  $stmt->execute([$_GET['id_parroquia']]);

  exit(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
}

if (key_exists('clientes', $_GET)) {
  require_once __DIR__ . '/config/Database.php';

  // Crear una instancia de la clase Database
  $database = new Database;
  $conn = $database->getConnection();

  // Consulta para obtener los datos de los clientes
  $sql = "
    SELECT
      c.cedula AS 'Cédula',
      c.primerNombre AS 'Primer Nombre',
      c.segundoNombre AS 'Segundo Nombre',
      c.primerApellido AS 'Primer Apellido',
      c.segundoApellido AS 'Segundo Apellido',
      t.telefonoPersonal AS 'Teléfono Personal',
      t.telefonoFijo AS 'Teléfono Fijo',
      t.telefonoOpcional AS 'Teléfono Opcional',
      CONCAT(ca.detalleCasaApartamento, ', ', cl.nombreCalle, ', ', av.nombreAvenida, ', ', p.nombreParroquia, ', ', m.nombreMunicipio, ', ', e.nombreEstado) AS 'Dirección'
    FROM Clientes c
    JOIN Telefonos t ON c.cedula = t.cedulaCliente
    JOIN Direcciones d ON c.cedula = d.cedulaCliente
    JOIN CasasApartamentos ca ON d.casaApartamentoId = ca.casaApartamentoId
    JOIN Calles cl ON ca.calleId = cl.calleId
    JOIN Avenidas av ON cl.avenidaId = av.avenidaId
    JOIN Parroquias p ON av.parroquiaId = p.parroquiaId
    JOIN Municipios m ON p.municipioId = m.municipioId
    JOIN Estados e ON m.estadoId = e.estadoId
  ";

  // Ejecutar la consulta y mostrar los datos en la tabla
  $stmt = $conn->query($sql);

  exit(json_encode([
    'data' => $stmt->fetchAll(PDO::FETCH_FUNC, static fn(...$client): array => [
      $client[0],
      $client[1],
      $client[2],
      $client[3],
      $client[4],
      $client[5],
      $client[6],
      $client[7],
      $client[8],
      <<<html
      <button
        class="btn btn-warning btn-sm"
        onclick="editClient('{$client[0]}')">
        Modificar
      </button>
      <button
        class="btn btn-danger btn-sm"
        onclick="deleteClient('{$client[0]}')">
        Eliminar
      </button>
      html
    ])
  ]));
}
