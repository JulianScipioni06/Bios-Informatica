<?php

if (!isset($_SESSION)) {
    session_start();
}

// recupera el link
// $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
// $host = $_SERVER['HTTP_HOST'];
// $requestUri = $_SERVER['REQUEST_URI'];
// $url = $scheme . '://' . $host . $requestUri;

class Conexion
{
    public $db;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "u718824031_bios";
        $username = "u718824031_bios";
        $password = "Bios2024";

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}

