
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
                    $.pjax.reload({container:"#new_localidad"}); //for pjax update
                    var n = noty({
                        text: ' Localidad agregada con éxito!',
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
                        text: response.message +' Localidad agregada con éxito!',
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

/********************************************************************************************************* */
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
                        text: ' Medico agregado con éxito!',
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
                        text: response.message +' Medico agregado con éxito!',
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

$(document).on('ready pjax:success', function () {

    $('.fa-info-circle').click(
        function(){
            $value = 'index.php?r=medico/createpop';
            $('#modalNuevoMedico').modal('show').find('#modalContent').load($value);
    });

});
    
/********************************************************************************************************* */


/********************************************************************************************************* */

    $("body").on("beforeSubmit", "form#create-procedencia-form-pop", function () {
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
                    $.pjax.reload({container:"#new_procedencia"}); //for pjax update
                    var n = noty({
                        text: ' Procedencia agregada con éxito!',
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
                        text: response.message +' Procedencia agregada con éxito!',
                        type: 'error',
                        class: 'animated pulse',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000, // delay for closing event. Set false for sticky notifications
                        force: false, // adds notification to the beginning of queue when set to true
                        modal: false, // si pongo true me hace el efecto de pantalla gris
                    });
                }
                $('#modalNuevaProcedencia').modal('hide');
            },
            error  : function () 
            {
                console.log("internal server error");
            }
        });
        return false;
});

    $('#addProcedencia').click(
        function(){
            $('#modalNuevaProcedencia').modal('show').find('#modalContentProcedencia').load($(this).attr('value'));
    });
    

/********************************************************************************************************* */

/********************************************************************************************************* */

    $("body").on("beforeSubmit", "form#create-prestadora-form-pop", function () {
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
                    //$.pjax.reload({container:"#new_prestadora"}); //for pjax update       
                    $(".selectoProcedencia").append("<option value="+response.data_id+">"+response.data_nombre+"</option>");
                    var n = noty({
                        text: ' Prestadora agregada con éxito!',
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
                        text: response.message +'Prestadora agregada con éxito!',
                        type: 'error',
                        class: 'animated pulse',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000, // delay for closing event. Set false for sticky notifications
                        force: false, // adds notification to the beginning of queue when set to true
                        modal: false, // si pongo true me hace el efecto de pantalla gris
                    });
                }
                $('#modalPrestadoras').modal('hide');
            },
            error  : function () 
            {
                console.log("internal server error");
            }
        });
        return false;
});

    $('#addPrestadoras').click(
        function(){
            $('#modalPrestadoras').modal('show').find('#divPrestadoras').load($(this).attr('value'));
    });
    

/********************************************************************************************************* */

/*
 $('.add-item').click(function() {
     var form = $(this);
       $.ajax({
            url    : "prestadoras/updatedataselect",
            type   : "post",
            data   : form.serialize(),
            success: function (response)
            {

                if (response.rta == "ok"){
                    $.each(response.data, function(key, value) {
                    $('.selectoProcedencia  :not(:selected)').append($("<option></option>")
                                    .attr("value",key)
                                    .text(value));
                     });

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

            },
            error  : function ()
            {
                console.log("internal server error");
            }
        });
        return false;
      
 });
    */
