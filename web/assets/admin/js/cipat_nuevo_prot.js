

function add_pac_prest() {
    $form = $("form#pac_prest");
    $.ajax({
        url: $form.attr("action"),
        type: "post",
        data: $form.serialize(),
        success: function (data) {
            //  $("#modal").modal("toggle");
            if (data.response == 'ok') {
                $(".lalala").html(data.data); //for pjax update
                var n = noty({
                    text: 'Se agregó la nueva prestadora al cliente',
                    type: 'success',
                    class: 'animated pulse',
                    layout: 'topRight',
                    theme: 'relax',
                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                    force: false, // adds notification to the beginning of queue when set to true
                    modal: false, // si pongo true me hace el efecto de pantalla gris
                });
                $('#pacienteprestadora-nro_afiliado').val('');

            }
            else {
                var n = noty({
                    text: data.msn,
                    type: 'error',
                    class: 'animated pulse',
                    layout: 'topRight',
                    theme: 'relax',
                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                    force: false, // adds notification to the beginning of queue when set to true
                    modal: false, // si pongo true me hace el efecto de pantalla gris
                });

            }
           
        },
        error: function () {
            console.log("internal server error");
        }
    });


    
    
}
/*
function showModal(valor) {
    alert(valor);
    $('#modalKoki').modal('show')
        .find('#modalContent').load(valor);
 //       .load('koko');
    //dynamiclly set the header for the modal
 //   document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4 > ';
};
*/

$("body").on("beforeSubmit", "form#update-paciente-form", function (event) {
    event.preventDefault();
    
   
    $("body").keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("#prestadoratemp-nro_afiliado").keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var form = $(this);
    // return false if form still have some validation errors
    if (form.find(".has-error").length) {
        return false;
    }
    // submit form
    $.ajax({
        url: form.attr("action"),
        type: "post",
        data: form.serialize(),
        success: function (response) {
            var n = noty({
                text: 'Entidad actualizada con éxito!',
                type: 'success',
                class: 'animated pulse',
                layout: 'topRight',
                theme: 'relax',
                timeout: 3000, // delay for closing event. Set false for sticky notifications
                force: false, // adds notification to the beginning of queue when set to true
                modal: false, // si pongo true me hace el efecto de pantalla gris
            });

        },
        error: function () {
            console.log("internal server error");
        }
    });
    return false;
});