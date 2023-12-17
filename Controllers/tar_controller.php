<?php

class Tarea_controller
{

    private $tarea;

    public function __construct()
    {
        include("../Models/tar_model.php");

        $this->tarea = new Tarea;
    }

    public function listar_tar($id_list)
    {
        $datos = $this->tarea->index_task($id_list);
        return $datos;
    }

    public function agregar_tar($desc_tar, $id_list)
    {
        $datos = $this->tarea->index_task($id_list);

        //poner la prioridad mas alta a la nueva tarea agregada
        $max_pri = 0;
        if ($datos->rowCount() > 0) {
            while ($reg = $datos->fetch(PDO::FETCH_ASSOC)) {

                if ($reg['prioridad'] > $max_pri) {
                    $max_pri = $reg['prioridad'];
                }
            }
        }
        $max_pri += 1;

        $this->tarea->set("desc_tar", $desc_tar);
        $this->tarea->set("prioridad", $max_pri);
        $this->tarea->set("id_list", $id_list);
        $this->tarea->add_task();
    }

    public function editar_tar($desc_tar, $fec_tar, $id_tar)
    {
        if ($fec_tar == null) {
            $fec_tar = null;
        }

        $this->tarea->set("desc_tar", $desc_tar);
        $this->tarea->set("fec_tar", $fec_tar);
        $this->tarea->set("id_tar", $id_tar);
        $this->tarea->edit_task();
    }

    public function eliminar_tar($id_tar)
    {
        $this->tarea->set("id_tar", $id_tar);
        $this->tarea->delete_task();
    }

    public function completar_tar($id_tar, $completado_act)
    {

        if ($completado_act == 0) {
            $completado = 1;
        } else {
            $completado = 0;
        }

        $this->tarea->set("id_tar", $id_tar);
        $this->tarea->set("completado", $completado);
        $this->tarea->update_complete();
    }

    public function mover_tar($pri_tar, $ids_tar)
    {

        for ($i = 0; $i < count($ids_tar); $i++) {
            $this->tarea->set("id_tar", $ids_tar[$i]);
            $this->tarea->set("prioridad", $pri_tar[$i]);
            $this->tarea->update_pri();
        }
    }

    public function formato_fecha_hora($fecha)
    {
        //Formatea (cambia el orden) la fecha y hora de ingles a español.
        $año = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $dia = substr($fecha, 8, 2);
        $fecha = $dia . '-' . $mes . '-' . $año;
        return $fecha;
    }
}

//llamadas a funciones

//mostrar tareas

if ($_POST['condicional'] == "mostrar tareas") {
    $datos = new Tarea_controller;
    $resultados = $datos->listar_tar($_POST['id_list']);

    $json = [];
    while ($reg = $resultados->fetch(PDO::FETCH_ASSOC)) {

        if ($reg['fec_tar'] == null) {
            $reg['fec_tar'] = "";
        } else {
            $reg['fec_tar'] = $datos->formato_fecha_hora($reg['fec_tar']);
            $reg['fec_tar'] = str_replace("-", "/", $reg['fec_tar']);
        }

        $json[] = [
            "id" => $reg['id_tar'],
            "descripcion" => $reg['desc_tar'],
            "fecha" => $reg['fec_tar'],
            "completado" => $reg['completado'],

        ];
    }
    $json = json_encode($json, JSON_PRETTY_PRINT);
    echo $json;
}

//agregar tarea

if ($_POST['condicional'] == "agregar tarea") {
    $datos = new Tarea_controller;
    $datos->agregar_tar($_POST['desc_tar'], $_POST['id_list']);
}

//editar tarea

if ($_POST['condicional'] == "editar tarea") {
    $datos = new Tarea_controller;
    $datos->editar_tar($_POST['desc_tar'], $_POST['fec_tar'], $_POST['id_tar']);
}

//eliminar tarea

if ($_POST['condicional'] == "eliminar tarea") {
    $datos = new Tarea_controller;
    $datos->eliminar_tar($_POST['id_tar']);
}

//completar tarea

if ($_POST['condicional'] == "completar tarea") {
    $datos = new Tarea_controller;
    $datos->completar_tar($_POST['id_tar'], $_POST['completado_act']);
}

//mover tarea

if ($_POST['condicional'] == "mover tarea") {
    $datos = new Tarea_controller;
    $datos->mover_tar($_POST['pri_tar'], $_POST['ids_tar']);
}
