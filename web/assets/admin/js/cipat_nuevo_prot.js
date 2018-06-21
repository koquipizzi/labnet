


function add_pac_prest() {
    $form = $("form#pac_prest");
    $.ajax({
        url: $form.attr("action"),
        type: "post",
        data: $form.serialize(),
        beforeSend: function (params) {
            let div = document.createElement("div");
            div.className = "loader";
            div.setAttribute("id", "loading");
            $(".addP").prepend(div);
        },
        success: function (data) {
            //  $("#modal").modal("toggle");
            if (data.response == 'ok') {
                $(".lalala").html(data.data); //for pjax update
                var n = noty({
                    text: 'Se agregó la nueva prestadora al paciente',
                    type: 'success',
                    class: 'animated pulse',
                    layout: 'topRight',
                    theme: 'relax',
                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                    force: false, // adds notification to the beginning of queue when set to true
                    modal: false, // si pongo true me hace el efecto de pantalla gris
                });
                $('#pacienteprestadora-nro_afiliado').val('');
                $('#pacienteprestadora-prestadoras_id').val('');
            }
            else {
                if (data.response == 'ko') {
                    var arr = data.msn;
                    jQuery.each(arr, function (i, val) {
                        var n = noty({
                            text: val,
                            type: 'error',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: false, // adds notification to the beginning of queue when set to true
                            modal: false
                        });
                    });
                }
                $(".addP").show();
            }
           
        },
        complete: function () {
            $('#loading').remove();
        },
        error: function () {
            console.log("internal server error");
        }
    });
    
}


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
            if (response.rta == 'ok') {
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
            }
            else {
                var n = noty({
                    text: 'sssss',
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
    return false;
});