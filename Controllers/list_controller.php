<?php

class Lista_controller
{
    private $lista;

    public function __construct()
    {
        include("../Models/list_model.php");

        $this->lista = new Lista;
    }

    //listas

    public function listar()
    {
        $datos = $this->lista->index();
        return $datos;
    }

    public function agregar($nom_list, $color_list)
    {
        $datos = $this->lista->index();
        $max_pri = 0;
        if ($datos->rowCount() > 0) {
            while ($reg = $datos->fetch(PDO::FETCH_ASSOC)) {

                if ($reg['prioridad'] > $max_pri) {
                    $max_pri = $reg['prioridad'];
                }
            }
        }
        $max_pri += 1;

        $this->lista->set("nom_list", $nom_list);
        $this->lista->set("color_list", $color_list);
        $this->lista->set("prioridad", $max_pri);
        $this->lista->add();
    }

    public function editar($id_list, $nom_list, $color_list)
    {
        $this->lista->set("id_list", $id_list);
        $this->lista->set("nom_list", $nom_list);
        $this->lista->set("color_list", $color_list);
        $this->lista->edit();
    }

    public function eliminar($id_list)
    {
        $this->lista->set("id_list", $id_list);
        $this->lista->delete();
    }

    public function ver($id_list)
    {
        $this->lista->set("id_list", $id_list);
        $reg = $this->lista->view();
        return $reg;
    }

    public function mover($ids_list, $pri_list)
    {
        for ($i = 0; $i < count($ids_list); $i++) {
            $this->lista->set("id_list", $ids_list[$i]);
            $this->lista->set("prioridad", $pri_list[$i]);
            $this->lista->update_pri();
        }
    }

    public function formato_fecha_hora($fecha)
    {
        //Formatea (cambia el orden) la fecha y hora de ingles a español.
        $año = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);
        $horacomp = substr($fecha, 11);
        $fecha = $dia . '-' . $mes . '-' . $año . " " . $horacomp;
        return $fecha;
    }
}

//llamadas a funciones

if (isset($_POST['condicional'])) {

    //mostrar listas
    if ($_POST['condicional'] == "mostrar listas") {
        $datos = new Lista_controller;
        $resultados = $datos->listar();

        $json = [];
        while ($reg = $resultados->fetch(PDO::FETCH_ASSOC)) {

            $json[] = [
                "id" => $reg['id_list'],
                "nombre" => $reg['nom_list'],
                "color" => $reg['color_list']

            ];
        }
        $json = json_encode($json, JSON_PRETTY_PRINT);
        echo $json;
    }

    //agregar lista
    if ($_POST['condicional'] == "agregar lista") {
        $datos = new Lista_controller;
        $datos->agregar($_POST['nom_list'], $_POST['color_list']);
    }


    //editar lista
    if ($_POST['condicional'] == "editar lista") {
        $datos = new Lista_controller;
        $datos->editar($_POST['id_list'], $_POST['nom_list'], $_POST['color_list']);
    }


    //eliminar lista
    if ($_POST['condicional'] == "eliminar lista") {
        $datos = new Lista_controller;
        $datos->eliminar($_POST['id_list']);
    }

    //ver lista
    if ($_POST['condicional'] == "ver lista") {
        $datos = new Lista_controller;
        $reg = $datos->ver($_POST['id_list']);

        $json = [
            "id" => $reg['id_list'],
            "nombre" => $reg['nom_list'],
            "color" => $reg['color_list']

        ];
        $json = json_encode($json);
        echo $json;
    }

    //mover lista
    if ($_POST['condicional'] == "mover lista") {
        $datos = new Lista_controller;
        $datos->mover($_POST['ids_list'], $_POST['pri_list']);
    }
}
