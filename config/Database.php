<?php

/** Clase para gestionar la conexión a la base de datos */
class Database
{
    // Propiedades privadas para los parámetros de conexión

    /** @var string Servidor */
    private $host = "localhost";

    /** @var string Nombre de la base de datos */
    private $db_name = "servimotorsdavila";

    /** @var string Usuario de la base de datos */
    private $username = "root";

    /** @var string Contraseña del usuario */
    private $password = "";

    /** @var ?PDO Variable para almacenar la conexión */
    private $conn = null;

    /** Método para obtener la conexión */
    public function getConnection()
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
