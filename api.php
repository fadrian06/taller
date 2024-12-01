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
