<?php

// Obtener la carpeta principal
$path_parts = explode('/', $_SERVER['REQUEST_URI']);
$principal_fold = $path_parts[1];

// URL principal 
$princ_url = $_SERVER["DOCUMENT_ROOT"] . '/' . $principal_fold;

if (file_exists($princ_url . '/Models/db_var.env')) {
    $dotenv = file_get_contents($princ_url . '/Models/db_var.env');
    $lines = explode("\n", $dotenv);

    foreach ($lines as $line) {

        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line);

        $_ENV[trim($key)] = trim($value);
    }
}

class Base_datos
{
    private static $host;
    private static $db;
    private static $user;
    private static $password;
    private static $port;
    private static $charset = "utf8";

    public function conectar()
    {
        self::$host = $_ENV["DB_HOST"];
        self::$db = $_ENV["DB_NAME"];
        self::$user = $_ENV["DB_USER"];
        self::$password = $_ENV["DB_PASSWORD"];
        self::$port = $_ENV["DB_PORT"];

        try {
            $con = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db . ";port=" . self::$port . ";charset=" . self::$charset, self::$user, self::$password);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $con;
        } catch (PDOException $e) {
            print_r("Error de conexion: " . $e->getMessage());

            echo "Linea del error" . $e->getLine();
        }
    }
}
