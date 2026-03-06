<?php

include_once("config.php");

class Model {
    private $db;

    // A konstruktor most már maga hozza létre a kapcsolatot a config.php konstansai alapján
    public function __construct() {
        $charset = 'utf8mb4';
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . $charset;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
             // Csapatvezetői tipp: Fejlesztés alatt jó a die(), de élesben majd naplózni kell
             die("Adatbázis csatlakozási hiba a Modelben: " . $e->getMessage());
        }
    }

    // Publikus menü lekérdezése
    public function getPublicMenu() {
        try {
            $sql = "SELECT * FROM menuk WHERE admin = 0 ORDER BY id ASC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Menü lekérdezési hiba: " . $e->getMessage());
            return [];
        }
    }
    
    
}