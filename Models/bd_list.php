<?php

class Base_datos
{
    private $host = "localhost";
    private $bd = "to_do_list";
    private $user = "root";
    private $contra = "";

    public function conectar()
    {
        try {
            $con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->bd, $this->user, $this->contra);

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $con;
        } catch (PDOException $e) {
            print_r("Error de conexion: " . $e->getMessage());

            echo "Linea del error" . $e->getLine();
        }
    }
}
