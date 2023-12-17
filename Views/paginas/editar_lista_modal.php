<link rel="stylesheet" href="../css/modal.css?v=<?php echo (rand()); ?>">

<script src="../js/select_color.js?v=<?php echo (rand()); ?>"></script>

<script>
    function abrir_cerrar_select_edit() {
        if ($("#select_color_edit img").css("rotate") == "0deg") {
            $("#selected_box_edit").css("border-radius", "10px 10px 0px 0px");
            $("#select_color_edit ul").slideDown(300, () => {
                $("#select_color_edit img").css("rotate", "180deg");
            })
        } else {
            $("#select_color_edit ul").slideUp(300, () => {
                $("#selected_box_edit").css("border-radius", "10px");
                $("#select_color_edit img").css("rotate", "0deg");
            })
        }
    }

    function cambiar_selected_edit(e) {

        let color = e.currentTarget.innerHTML;

        $("#selected_box_edit").html(color);

        $("#select_color_edit ul").slideUp(300, () => {
            $("#selected_box_edit").css("border-radius", "10px");
            $("#select_color_edit img").css("rotate", "0deg");
        })

    }


    $("document").ready(() => {
        $("#selected_box_edit").click(abrir_cerrar_select_edit);

        $("#select_color_edit ul li").click((e) => {
            cambiar_selected_edit(e);
        })

    })
</script>

<div class="modal_fade_edit">
    <div class="modal_cont_edit">
        <img id="salir_edit" src="../img/xmark-solid.svg" title="Salir">

        <header class="modal_header">
            Editar lista
        </header>
        <div class="modal_contenido">
            <form>
                <label for="nom_list_edit">
                    <span class="span_prin">Nombre</span> <br>
                    <input type="text" id="nom_list_edit" name="nom_list_edit" maxlength="200" placeholder="Ingresa un nombre..." required>
                </label>
                <label>
                    <span class="span_prin" id="span_color">Color</span>

                    <div id="select_color_edit">
                        <div id="selected_box_edit">Seleccione un color...</div>
                        <img src="../img/caret-down-solid.svg">

                        <ul>
                            <li>
                                <div class="color" style="background-color: yellow;"></div><span>Amarillo</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: blue;"></div><span>Azul</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: darkblue;"></div><span>Azul oscuro</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: crimson;"></div><span>Carmesí</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: aqua;"></div><span>Celeste</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: fuchsia;"></div><span>Fucsia</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: indigo;"></div><span>Indigo</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: lime;"></div><span>Lima</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: orange;"></div><span>Naranja</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: purple;"></div><span>Purpura</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: red;"></div><span>Rojo</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: darkred;"></div><span>Rojo oscuro</span>
                            </li>

                            <li>
                                <div class="color" style="background-color: rgb(0,180,0);"></div><span>Verde</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: green;"></div><span>Verde oscuro</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: springgreen;"></div><span>Verde primavera</span>
                            </li>
                            <li>
                                <div class="color" style="background-color: violet;"></div><span>Violeta</span>
                            </li>

                            <li>
                                <div class="color" style="background-color: darkviolet;"></div><span>Violeta oscuro</span>
                            </li>

                        </ul>
                    </div>
                </label>
                <span id="error_edit"><b>Error:</b> Complete el formulario</span>
                <button id="btn_editar_lista" type="button">Editar</button>
            </form>
        </div>
    </div>

</div>