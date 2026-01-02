<?php
define("DB_HOST", "localhost");
define("DB_PORT", "3306");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "devjobs");
class DB{
    public string $hostDB;

    public function __construct() {
        $this->hostDB = "mysql:host=" . DB_HOST .
                     ";port=" . DB_PORT .
                     ";dbname=" . DB_NAME .
                     ";charset=utf8mb4";
    }

    public function get_db(): PDO {
        try {
            $pdo = new PDO($this->hostDB, DB_USER, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //permite la devolucion de la excepcion
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); //evita duplicaicones de datos en el fetch
            return $pdo;
        } catch (PDOException $e) {
            die("ERROR: No se pudo conectar a la base de datos: " . $e->getMessage());
        }
    }

    public function closes_cursor(PDOStatement $stmt): void {
        try {
            $stmt->closeCursor();
        } catch (PDOException $e) {
            die("ERROR: No se pudo cerrar la comunicacion a la base de datos: " . $e->getMessage());
        }
    }
}

?>