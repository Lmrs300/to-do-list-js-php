<?php

/*include("../../Controllers/list_controller.php");

$datos = new Lista_controller;

$listas = $datos->listar();*/

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas</title>
    <link rel="icon" href="../img/to-do-list.ico">
    <link rel="stylesheet" href="../css/listas.css?v=<?php echo (rand()); ?>">

    <script src="../js/jquery-3.6.4.min.js"></script>

    <script src="../js/listas_func.js?v=<?php echo (rand()); ?>"></script>

    <script src="../js/Sortable.min.js"></script>

    <script>
        $("document").ready(() => {

            //mostrar listas
            mostrar_lista();


            //mover listas
            mover_listas();

            //abrir modal
            $("#add_list").click(abrir_modal);
            //cerrar modal
            $("#salir").click(cerrar_modal);

            //crear lista
            $("#btn_crear_lista").click(crear_lista);

            //Abrir modal editar lista
            $(document).on("click", ".edit_list", async function(e) {

                $(e.currentTarget.parentElement).addClass("select_edit");

                id = $(".select_edit div").html();

                let lista = await ver_lista(id);

                llenar_campos(lista);

                abrir_modal_edit();
            });

            //cerrar modal editar lista
            $("#salir_edit").click(cerrar_modal_edit);

            //editar lista
            $("#btn_editar_lista").click(() => {
                id = $(".select_edit div").html();
                editar_lista(id);
            });


            //asignar evento click a todos los ".btn_elim_lista" y abrir modal eliminar

            //Nota: aqui por alguna razon, si se coloca "(e)=>" en vez de "function(e)" el evento "e" hace referencia a la ventana y no al boton.
            $(document).on("click", ".btn_elim_lista", function(e) {
                abrir_modal_elim(e);
            })


            //cerrar modal eliminar

            $("#salir_elim").click(cerrar_modal_elim);

            //eliminar lista
            $("#btn_con_elim_lista").click(() => {
                //obtener id
                let id = $(".select_elim div").html();

                //eliminar
                elim_lista(id);
            });
        })
    </script>
</head>

<body>
    <?php
    include("crear_lista_modal.php");

    include("editar_lista_modal.php");

    include("eliminar_modal.php");
    ?>
    <h1>Listas</h1>

    <button id="add_list">Crear Lista</button>

    <ul id="ul_listas"></ul>


</body>

</html>