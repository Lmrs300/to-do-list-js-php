<?php
class Tarea
{
    private $id_tar;
    private $desc_tar;
    private $fec_tar;
    private $completado;
    private $prioridad;
    private $id_list;
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

    public function index_task($id_list)
    {
        $sql = "SELECT * FROM tareas WHERE id_list=:id_list ORDER BY prioridad ASC";

        $query = $this->con->prepare($sql);

        $query->execute(array(":id_list" => $id_list));

        return $query;
    }

    public function add_task()
    {
        $sql = "INSERT INTO tareas VALUES (null,:desc_tar,null,0,:prioridad,:id_list)";

        $query = $this->con->prepare($sql);

        $query->execute(array(":desc_tar" => $this->desc_tar, ":prioridad" => $this->prioridad, ":id_list" => $this->id_list));
    }

    public function edit_task()
    {
        $sql = "UPDATE tareas SET desc_tar=:desc_tar, fec_tar=:fec_tar WHERE id_tar=:id_tar";

        $query = $this->con->prepare($sql);

        $query->execute(array(":desc_tar" => $this->desc_tar, ":fec_tar" => $this->fec_tar, ":id_tar" => $this->id_tar));
    }

    public function delete_task()
    {
        $sql = "DELETE FROM tareas WHERE id_tar=:id_tar";

        $query = $this->con->prepare($sql);

        $query->execute(array(":id_tar" => $this->id_tar));

        return $query;
    }

    public function update_complete()
    {
        $sql = "UPDATE tareas SET completado=:completado WHERE id_tar=:id_tar";

        $query = $this->con->prepare($sql);

        $query->execute(array(":completado" => $this->completado, ":id_tar" => $this->id_tar));
    }

    public function update_pri()
    {
        $sql = "UPDATE tareas SET prioridad=:prioridad WHERE id_tar=:id_tar";

        $query = $this->con->prepare($sql);

        $query->execute(array(":prioridad" => $this->prioridad, ":id_tar" => $this->id_tar));
    }
}
