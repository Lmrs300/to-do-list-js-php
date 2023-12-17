function abrir_cerrar_select() {
    if ($("#select_color img").css("rotate") == "0deg") {
        $("#selected_box").css("border-radius", "10px 10px 0px 0px");
        $("#select_color ul").slideDown(300, () => {
            $("#select_color img").css("rotate", "180deg");
        })
    } else {
        $("#select_color ul").slideUp(300, () => {
            $("#selected_box").css("border-radius", "10px");
            $("#select_color img").css("rotate", "0deg");
        })
    }
}

function cambiar_selected(e) {

    let color = e.currentTarget.innerHTML;

    $("#selected_box").html(color);

    $("#select_color ul").slideUp(300, () => {
        $("#selected_box").css("border-radius", "10px");
        $("#select_color img").css("rotate", "0deg");
    })

}


$("document").ready(() => {
    $("#selected_box").click(abrir_cerrar_select);

    $("#select_color ul li").click((e) => {
        cambiar_selected(e);
    })

})