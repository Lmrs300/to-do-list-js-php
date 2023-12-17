<?php

if (isset($_GET['id_list'])) {
    $id_list = $_GET['id_list'];

    $nombre = $_GET['nom_list'];

    $color = $_GET['color_list'];

    $color_rgba = substr_replace($color, "", 0, 3);

    $color_rgba = substr_replace($color_rgba, "", -1);

    $color_rgba = "rgba" . $color_rgba . ",0.5)";
} else {
    header("Location: listas.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="icon" href="../img/to-do-list.ico">

    <link rel="stylesheet" href="../css/main_list.css?v=<?php echo (rand()); ?>">

    <style>
        #main_list {
            border-top-color: <?php echo $color ?>;
        }

        #btn_add {
            background: <?php echo $color ?>;
        }

        .tarea .div_fecha {
            background-color: <?php echo $color_rgba ?>;
        }

        .fec_radio:checked {
            background-color: <?php echo $color ?> !important;
        }
    </style>

    <script src="../js/jquery-3.6.4.min.js"></script>

    <script src="../js/Sortable.min.js"></script>

    <script>
        function showTask() {

            let id_list = <?php echo $id_list ?>;

            $.ajax({
                url: "./../../Controllers/tar_controller.php",
                type: "POST",
                data: {
                    id_list: id_list,
                    condicional: "mostrar tareas"
                }

            }).done((res) => {
                //el if es por si no hay tareas
                $("#ul_tasks").html("");
                if (res != "[]") {
                    tareas = JSON.parse(res)

                    let contador = 1;
                    tareas.forEach(function(tarea) {
                        if (tarea.completado == 0) {
                            $("#ul_tasks").append(
                                "<li class='tarea' prioridad='" + contador + "'><div class=id_tar style='display:none;'>" + tarea.id + "</div><img class='check' completado='" + tarea.completado + "' src='../img/circle-regular-blue.svg'><span>" + tarea.descripcion +
                                "</span><div class='div_fecha'>" + tarea.fecha +
                                "</div><img class='editar' src='../img/pen-to-square-solid-yellow.svg'><img class='eliminar' src='../img/xmark-solid-red.svg'></li>")
                        } else {
                            $("#ul_tasks").append(
                                "<li class='tarea' prioridad='" + contador + "'><div class=id_tar style='display:none;'>" + tarea.id + "</div><img class='check' completado='" + tarea.completado + "' src='../img/circle-check-solid-blue.svg'><span style='text-decoration: 2px line-through red;'>" + tarea.descripcion +
                                "</span><div class='div_fecha'>" + tarea.fecha +
                                "</div><img class='editar' src='../img/pen-to-square-solid-yellow.svg'><img class='eliminar' src='../img/xmark-solid-red.svg'></li>");
                        }
                        contador++;
                    })

                    //para que si no hay fecha no se vea el contenedor
                    $(".div_fecha").each(function() {
                        if ($(this).html() == "") {
                            $(this).css("background", "none");
                        }
                    })

                    setTimeout(() => {
                        $("#ul_tasks").slideDown(500);
                    }, 300);



                } else {
                    $("#ul_tasks").slideUp(500);
                }
            }).fail(() => {
                alert("Error: no se pudo conectar con el servidor.");
            });

        }

        function addTask() {

            let desc = $("#input_task").val();

            let id_list = <?php echo $id_list ?>;



            $.ajax({
                url: "./../../Controllers/tar_controller.php",
                type: "POST",
                data: {
                    desc_tar: desc,
                    id_list: id_list,
                    condicional: "agregar tarea"
                }

            }).done(() => {
                $("#input_task").val("");

                showTask()
            }).fail(() => {
                alert("Error: no se pudo conectar con el servidor.");
            });

        }

        function editTask(id) {
            let desc_tar = $("#desc_tar").val();

            if ($("#rad_sin_fec").prop("checked") == true) {
                var fec_tar = null;
            } else if ($("#rad_fec").prop("checked") == true) {
                var fec_tar = $("#fec_tar").val();
            } else {
                var fec_tar = null;
            }

            if (desc_tar != "" && fec_tar != "") {

                $.ajax({
                    url: "./../../Controllers/tar_controller.php",
                    type: "POST",
                    data: {
                        desc_tar: desc_tar,
                        fec_tar: fec_tar,
                        id_tar: id,
                        condicional: "editar tarea"
                    }
                }).done(() => {
                    cerrarModalEdit()
                    showTask()
                }).fail(() => {
                    alert("Error: no se pudo conectar con el servidor.");
                })

            } else {
                $("#error_edit").show();
            }
        }

        function deleteTask(e) {

            $(e.currentTarget.parentElement).addClass("del_task");


            let id = $(".del_task .id_tar").html();

            $(e.currentTarget.parentElement).removeClass("del_task");


            $.ajax({
                url: "./../../Controllers/tar_controller.php",
                type: "POST",
                data: {
                    id_tar: id,
                    condicional: "eliminar tarea"
                }

            }).done(() => {
                showTask();

            }).fail(() => {
                alert("Error: no se pudo conectar con el servidor.");
            });

        }

        function completeTask(e) {
            $(e.currentTarget.parentElement).addClass("com_task");


            let id = $(".com_task .id_tar").html();

            let completado = $(".com_task .check").attr("completado");

            $.ajax({
                url: "./../../Controllers/tar_controller.php",
                type: "POST",
                data: {
                    id_tar: id,
                    completado_act: completado,
                    condicional: "completar tarea"
                }

            }).done(() => {
                showTask();
            }).fail(() => {
                alert("Error: no se pudo conectar con el servidor.");
            });
        }

        function fullFields(desc, fecha) {
            $("#desc_tar").val(desc);

            if (fecha != "") {
                $("#rad_fec").prop("checked", true)
                $("#fec_tar").show();

                fecha = formatDate(fecha);
                $("#fec_tar").val(fecha);
            } else {
                $("#rad_sin_fec").prop("checked", true)
                $("#fec_tar").hide();

                $("#fec_tar").val("");
            }


        }

        function moveTask() {
            let ul_tasks = document.getElementById("ul_tasks");

            Sortable.create(ul_tasks, {
                animation: 150,
                chosenClass: "li_sel",
                dragClass: "li_drag",
                group: "tareas",
                onEnd: (ids_tar) => {


                    var ids_tar = [];
                    $(".id_tar").each(function() {
                        ids_tar.push($(this).html())
                    })

                    let pri_tar = [];
                    $(".tarea").each(function() {
                        pri_tar.push($(this).attr("prioridad"))
                    });

                    pri_tar.sort();
                    $.ajax({
                        url: "./../../Controllers/tar_controller.php",
                        type: "POST",
                        data: {
                            pri_tar: pri_tar,
                            ids_tar: ids_tar,
                            condicional: "mover tarea"
                        }
                    }).done().fail(() => {
                        alert("Error: no se pudo conectar con el servidor.");
                    });
                }
            });
        }

        function openModalEdit() {
            $(".modal_fade_edit").css("display", "flex");
            $(".modal_cont_edit").fadeIn(500);
        }

        function cerrarModalEdit() {
            //cerrar modal
            $(".modal_fade_edit").css("display", "none");
            $(".modal_cont_edit").fadeOut(500);
            $(".select_edit").removeClass("select_edit");

            //reiniciar modal
            $("#desc_tar").val("");

            $("#fec_tar").val("");

            $("#error_edit").hide()

        }

        function formatDate(fecha) {
            //Formatea (cambia el orden) la fecha de español a ingles.
            let dia = fecha.substr(0, 2);
            let mes = fecha.substr(3, 2);
            let año = fecha.substr(6, 4);
            fecha = año + '-' + mes + '-' + dia;
            return fecha;
        }

        $("document").ready(() => {
            $("#main_list").fadeIn(500);
            //mostrar tareas
            showTask();

            //mover tareas
            moveTask();


            //agregar tarea
            $("#btn_add").click(addTask);

            //editar tarea
            $("#btn_editar_tarea").click(() => {

                let id = $(".select_edit .id_tar").html()
                editTask(id);
            });

            //eliminar tarea
            $(document).on("click", ".eliminar", function(e) {
                deleteTask(e);
            })

            //completar tarea
            $(document).on("click", ".check", function(e) {
                completeTask(e);
            })


            //abrir modal editar tarea

            $(document).on("click", ".editar", function(e) {

                $(e.currentTarget.parentElement).addClass("select_edit");

                let desc = $(".select_edit span").html();

                let fecha = $(".select_edit .div_fecha").html();

                fullFields(desc, fecha);

                openModalEdit();
            });

            //cerrar modal editar tarea
            $("#salir_edit").click(cerrarModalEdit);

        })
    </script>

</head>

<body>

    <?php
    include("modal_editar_tar.php");
    ?>

    <div id="main_list">
        <a href="listas.php" id="volver" title="Volver"><img src="../img/arrow-left-long-solid.svg"></a>
        <div id="main_title">
            <h1><?php echo $nombre ?></h1>
        </div>

        <form>
            <input type="text" id="input_task" name="input_task" placeholder="Añade una tarea...">
            <button type="button" id="btn_add" title="Agregar tarea">+</button>
        </form>
        <ul id="ul_tasks">

        </ul>

    </div>


</body>

</html>