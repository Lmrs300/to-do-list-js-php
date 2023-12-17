<link rel="stylesheet" href="../css/modal.css?v=<?php echo (rand()); ?>">


<script>
    $(document).ready(() => {
        $("#rad_sin_fec").click(() => {
            $("#fec_tar").slideUp(300);

        })
        $("#rad_fec").click(() => {
            $("#fec_tar").slideDown(300);
        })
    })
</script>

<div class="modal_fade_edit">
    <div class="modal_cont_edit">
        <img id="salir_edit" src="../img/xmark-solid.svg" title="Salir">

        <header class="modal_header">
            Editar tarea
        </header>
        <div class="modal_contenido">
            <form>
                <label for="desc_tar">
                    <span class="span_prin">Tarea</span> <br>
                    <input type="text" id="desc_tar" name="desc_tar" maxlength="200" placeholder="Ingresa una tarea..." required>
                </label>

                <span id="span_fecha">Fecha</span>
                <div id="div_radios">

                    <label for="rad_sin_fec"><input type="radio" name="fec_radio" id="rad_sin_fec" class="fec_radio" checked><br>Sin fecha</label>

                    <label for="rad_fec"><input type="radio" name="fec_radio" id="rad_fec" class="fec_radio"><br>Con fecha</label>

                </div>

                <label for="fec_tar">
                    <input type="date" name="fec_tar" id="fec_tar" max="9999-12-31">
                </label>
                <span id="error_edit"><b>Error:</b> Complete el formulario</span>
                <button id="btn_editar_tarea" type="button">Editar</button>
            </form>
        </div>
    </div>

</div>