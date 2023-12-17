<?php

class Lista
{
    private $id_list;
    private $nom_list;
    private $color_list;
    private $prioridad;
    private $con;

    public function __construct()
    {
        include("bd_list.php");
        $this->con = new Base_datos;

        $this->con = $this->con->conectar();
    }


    public function set($atributo, $contenido)
    {
        $this->$atributo = $contenido;
    }

    public function index()
    {
        $sql = "SELECT * FROM listas ORDER BY prioridad ASC";

        $query = $this->con->query($sql);

        return $query;
    }

    public function add()
    {
        $sql = "INSERT INTO listas VALUES (null,:nom_list,:color_list,:prioridad)";

        $query = $this->con->prepare($sql);

        $query->execute(array(":nom_list" => $this->nom_list, ":color_list" => $this->color_list, ":prioridad" => $this->prioridad));
    }

    public function edit()
    {
        $sql = "UPDATE listas SET nom_list=:nom_list, color_list=:color_list WHERE id_list=:id_list";

        $query = $this->con->prepare($sql);

        $query->execute(array(":nom_list" => $this->nom_list, ":color_list" => $this->color_list, ":id_list" => $this->id_list));
    }

    public function delete()
    {
        $sql = "DELETE FROM listas WHERE id_list=:id_list";

        $query = $this->con->prepare($sql);

        $query->execute(array(":id_list" => $this->id_list));
    }

    public function view()
    {
        $sql = "SELECT * FROM listas WHERE id_list=:id_list";

        $datos = $this->con->prepare($sql);

        $datos->execute(array(":id_list" => $this->id_list));

        $reg = $datos->fetch(PDO::FETCH_ASSOC);

        return $reg;
    }

    public function update_pri()
    {
        $sql = "UPDATE listas SET prioridad=:prioridad WHERE id_list=:id_list";

        $query = $this->con->prepare($sql);

        $query->execute(array(":prioridad" => $this->prioridad, ":id_list" => $this->id_list));
    }
}
