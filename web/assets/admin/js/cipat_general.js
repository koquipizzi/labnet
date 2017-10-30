
$(document).on('ready', function () {   
    

    $(function check_order(){
        $( "a" ).each(function( index ) {
            var attr = $(this).attr('data-sort');
            if (typeof attr !== typeof undefined && attr !== false) {
                 //   console.log( "a: " + $( this ).text() );
                 $(this).addClass('sorting');            
            }
        });    
    });
    
    $("body").on("beforeSubmit", "form#create-localidad-form-pop", function () {
        //alert("ddddd");
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find(".has-error").length) 
        {
            return false;
        }
        // submit form
        $.ajax({
            url    : form.attr("action"),
            type   : "post",
            data   : form.serialize(),
            success: function (response) 
            {
                if (response.rta == "ok"){
                    //alert(response);
                //   $("#modal").modal("toggle");
                    $.pjax.reload({container:"#new_localidad"}); //for pjax update
                    var n = noty({
                        text: ' agregada con éxito!',
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
                        text: response.message +' agregada con éxito!',
                        type: 'error',
                        class: 'animated pulse',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000, // delay for closing event. Set false for sticky notifications
                        force: false, // adds notification to the beginning of queue when set to true
                        modal: false, // si pongo true me hace el efecto de pantalla gris
                    });
                }
                $('#modalPaciente').modal('hide');
            },
            error  : function () 
            {
                console.log("internal server error");
            }
        });
        return false;
});

    $('#addLocalidad').click(
        function(){
            $('#modalPaciente').modal('show').find('#modalContent').load($(this).attr('value'));
    });


    $("body").on("beforeSubmit", "form#create-medico-form-pop", function () {
        //alert("ddddd");
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find(".has-error").length) 
        {
            return false;
        }
        // submit form
        $.ajax({
            url    : form.attr("action"),
            type   : "post",
            data   : form.serialize(),
            success: function (response) 
            {
                if (response.rta == "ok"){
                    //alert(response);
                //   $("#modal").modal("toggle");
                    $.pjax.reload({container:"#new_medico"}); //for pjax update
                    var n = noty({
                        text: ' agregada con éxito!',
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
                        text: response.message +' agregada con éxito!',
                        type: 'error',
                        class: 'animated pulse',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000, // delay for closing event. Set false for sticky notifications
                        force: false, // adds notification to the beginning of queue when set to true
                        modal: false, // si pongo true me hace el efecto de pantalla gris
                    });
                }
                $('#modalNuevoMedico').modal('hide');
            },
            error  : function () 
            {
                console.log("internal server error");
            }
        });
        return false;
});

    $('#addMedico').click(
        function(){
            $('#modalNuevoMedico').modal('show').find('#modalContent').load($(this).attr('value'));
    });
    


    
});



    