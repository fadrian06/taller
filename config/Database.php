<?php

/** Clase para gestionar la conexión a la base de datos */
final class Database
{
  // Propiedades privadas para los parámetros de conexión
  /** Servidor */
  private string $host = 'localhost';

  /** Nombre de la base de datos */
  private string $db_name = 'servimotorsdavila';

  /** Usuario de la base de datos */
  private string $username = 'root';

  /** Contraseña del usuario */
  private string $password = '';

  /** Variable para almacenar la conexión */
  private ?PDO $conn = null;

  /** @deprecated Método para obtener la conexión */
  public function getConnection(): PDO
  {
    try {
      /** Crear una instancia de PDO para conectarse a la base de datos */
      $this->conn = new PDO(
        "mysql:host=$this->host;dbname=$this->db_name",
        $this->username,
        $this->password
      );

      // Configurar el modo de error para que use excepciones
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      // Mostrar un mensaje en caso de error
      echo "Connection error: {$e->getMessage()}";
    }

    return $this->conn; // Devolver la conexión
  }
}
