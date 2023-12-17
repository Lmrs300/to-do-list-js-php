function mostrar_lista() {
    $.ajax({
        url: "./../../Controllers/list_controller.php",
        type: "POST",
        data: {
            condicional: "mostrar listas"
        }
    }).done((res) => {
        listas = JSON.parse(res)
        $("#ul_listas").html("");
        var contador = 1;
        listas.forEach(function (lista) {
            $("#ul_listas").append("<li class='lista' prioridad='" + contador + "' style='border-top: 15px solid " + lista.color + ";'><div class='id_div' style='display:none;'>" + lista.id + "</div><span>" + lista.nombre + "</span><a href='main_list.php?id_list=" + lista.id + "&nom_list=" + lista.nombre + "&color_list=" + lista.color + "' title='Ver lista'><img src='../img/eye-solid-white.svg'></a><button class='edit_list' type='button' title='Editar lista'><img src='../img/pen-to-square-solid-white.svg'></button><button class='btn_elim_lista' type='button' title='Eliminar lista'><img src='../img/trash-can-solid-white.svg'></button></li>");

            contador++;
        });
        setTimeout(() => {
            $("#ul_listas").fadeIn(800);
            $("#ul_listas").css("display", "flex");
        }, 1200);

    }).fail(() => {
        alert("Error: no se pudo conectar con el servidor.");
    });

}

function elim_lista(id) {
    $.ajax({
        url: "./../../Controllers/list_controller.php",
        type: "POST",
        data: {
            id_list: id,
            condicional: "eliminar lista"
        }
    }).done(() => {
        mostrar_lista();
        cerrar_modal_elim();
    }).fail(() => {
        alert("Error: no se pudo conectar con el servidor.");
    })

}


function crear_lista() {
    let nom_list = $("#nom_list").val();

    let color_list = $("#selected_box .color").css("background-color");

    if (nom_list != "" && color_list != undefined) {

        $.ajax({
            url: "./../../Controllers/list_controller.php",
            type: "POST",
            data: {
                nom_list: nom_list,
                color_list: color_list,
                condicional: "agregar lista"
            }
        }).done(() => {
            cerrar_modal()
            mostrar_lista()
        }).fail(() => {
            alert("Error: no se pudo conectar con el servidor.");
        })

    } else {
        $("#error").show()
    }
}

function editar_lista(id) {
    let nom_list = $("#nom_list_edit").val();

    let color_list = $("#selected_box_edit .color").css("background-color");

    if (nom_list != "" && color_list != undefined) {

        $.ajax({
            url: "./../../Controllers/list_controller.php",
            type: "POST",
            data: {
                id_list: id,
                nom_list: nom_list,
                color_list: color_list,
                condicional: "editar lista"
            }
        }).done(() => {
            cerrar_modal_edit()
            mostrar_lista()
        }).fail(() => {
            alert("Error: no se pudo conectar con el servidor.");
        })

    } else {
        $("#error_edit").show()
    }
}

async function ver_lista(id) {
    //NOTA= esto lo tendre que hacer con fetch
    await $.ajax({
        url: "./../../Controllers/list_controller.php",
        type: "POST",
        data: {
            id_list: id,
            condicional: "ver lista"
        }
    }).done((res) => {
        lista = JSON.parse(res);

    }).fail(() => {
        alert("Error: no se pudo conectar con el servidor.");
    })
    //alert(lista)

    return lista;

}

function llenar_campos(lista) {
    $("#nom_list_edit").val(lista.nombre);

    let li_color = $("#select_color_edit ul li .color");

    li_color.each(function () {
        if ($(this).css("background-color") == lista.color) {
            console.log($(this).parent().html())
            let selected_box_color = $(this).parent().html()

            $("#selected_box_edit").html(selected_box_color);
        }
    })
}

function mover_listas() {
    let ul_list = document.getElementById("ul_listas");

    Sortable.create(ul_list, {
        animation: 150,
        chosenClass: "li_sel",
        dragClass: "li_drag",
        group: "listas",
        onEnd: (ids_list) => {

            var ids_list = [];
            $(".id_div").each(function () {
                ids_list.push($(this).html())
            })

            let pri_list = [];
            $(".lista").each(function () {
                pri_list.push($(this).attr("prioridad"))
            });

            pri_list.sort();
            $.ajax({
                url: "./../../Controllers/list_controller.php",
                type: "POST",
                data: {
                    pri_list: pri_list,
                    ids_list: ids_list,
                    condicional: "mover lista"
                }
            }).done().fail(() => {
                alert("Error: no se pudo conectar con el servidor.");
            });
        }
    });
}



function abrir_modal() {
    $(".modal_fade").css("display", "flex");
    $(".modal_cont").fadeIn(500);
    $("#add_list").css("background", "rgb(0,180,0)");
}

function cerrar_modal() {
    //cerrar modal
    $(".modal_fade").css("display", "none");
    $(".modal_cont").fadeOut(500);
    $("#add_list").css("background", "");

    //reiniciar modal
    $("#nom_list").val("");

    $("#selected_box").html("Seleccione un color...");

    $("#error").hide()

    $("#select_color ul").slideUp(300, () => {
        $("#selected_box").css("border-radius", "10px");
        $("#select_color img").css("rotate", "0deg");
    })
}

function abrir_modal_edit() {
    $(".modal_fade_edit").css("display", "flex");
    $(".modal_cont_edit").fadeIn(500);
}

function cerrar_modal_edit() {
    //cerrar modal
    $(".modal_fade_edit").css("display", "none");
    $(".modal_cont_edit").fadeOut(500);
    $(".select_edit").removeClass("select_edit");

    //reiniciar modal
    $("#nom_list_edit").val("");

    $("#selected_box_edit").html("Seleccione un color...");

    $("#error_edit").hide()

    $("#select_color_edit ul").slideUp(300, () => {
        $("#selected_box_edit").css("border-radius", "10px");
        $("#select_color_edit img").css("rotate", "0deg");
    })
}

function abrir_modal_elim(e) {
    $(".modal_fade_elim").css("display", "flex");
    $(".modal_cont_elim").fadeIn(500);


    $(e.currentTarget.parentElement).addClass("select_elim");

    let nom_list = $(".select_elim span").html();
    $(".modal_contenido_elim p b").html(nom_list);
}

function cerrar_modal_elim() {
    $(".modal_fade_elim").css("display", "none");
    $(".modal_cont_elim").fadeOut(500);

    $(".select_elim").removeClass("select_elim");
}