
    $('.mostrarTree').on('click', function (e) { //toggle de estudios
        $('.tree-view-wrapper').toggle();
    });    
    
        
    $('.click').on('click', function (e) {
        e.preventDefault();        
        var $url = 'index.php?r=informe-nomenclador/create'; 
        $p = $('#popNomenclador');       
        $p.on('show.bs.modal', function (e) {
            $('#informenomenclador-cantidad').val("");
        });

        $.ajax({
                type: "POST",
                url: $url,               
                dataType: "JSON",
                data: $('#addNom').serialize(), 
                success: function(response) {                     
                    if (response.rta == 'ok'){
                        $.pjax.reload({container:"#nomencladores"}); 
                        var n = noty({
                                text:  response.message,
                                type: 'success',
                                class: 'animated pulse',
                                layout: 'topRight',
                                theme: 'relax',
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force: false, // adds notification to the beginning of queue when set to true
                                modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                        $p.popoverX('hide');
                    }else if(response.rta == 'error'){                        
                        $('.field-informenomenclador-cantidad').removeClass('has-success');
                        $('.field-informenomenclador-cantidad').addClass('has-error');
                        $('.field-informenomenclador-cantidad .help-block').html(response.message.cantidad[0]);
                    }                    
                    else { // el nomenclador ya se encuentra agregado
                        var n = noty({
                                text:  response.message,
                                type: 'error',
                                class: 'animated pulse',
                                layout: 'topRight',
                                theme: 'relax',
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force: false, // adds notification to the beginning of queue when set to true
                                modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                            $p.popoverX('hide');
                    }
                }
           });
    }); // Agregar Nomenclador
        
 
    $('.change-estado').on('click', function () {
        var $estado = $(this).data('estado');
        var $informe = $(this).data('informe');    
        var $workflow = $(this).data('workflow');
        var $workflow = $(this).data('usuario');
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd='0'+dd
        } 
        if(mm<10) {
            mm='0'+mm
        } 
        $today = yyyy +'-'+ mm+'-'+dd;
        //document.write(today);
        $url = 'index.php?r=workflow/updatestados'; 
        $.ajax({
                url    : $url,
                type   : "post",
                dataType: "JSON",
                data: {
                        'id' : $workflow,
                        'estado' : $estado,
                        'Workflow[fecha_fin]' : $today,
                        'Workflow[Informe_id]': $informe,
                        'Workflow[Responsable_id]': $workflow
                       },                          
                success: function (response) 
                {
                    if (response.result == 'ok'){
                                    $.pjax.reload({container:"#estado"});
                                    var n = noty({
                                        text: response.mensaje,
                                        type: 'success',
                                        class: 'animated pulse',
                                        layout: 'topRight',
                                        theme: 'relax',
                                        timeout: 3000, // delay for closing event. Set false for sticky notifications
                                        force: true, // adds notification to the beginning of queue when set to true
                                        modal: false, // si pongo true me hace el efecto de pantalla gris
                                        killer: true
                                    });
                    }else if (response.result == 'error'){
                                     var n = noty({
                                      text: response.mensaje,
                                      type: 'success',
                                      class: 'animated pulse',
                                      layout: 'topRight',
                                      theme: 'relax',
                                      timeout: 3000, // delay for closing event. Set false for sticky notifications
                                      force: true, // adds notification to the beginning of queue when set to true
                                      modal: false, // si pongo true me hace el efecto de pantalla gris
                                      killer: true
                                  });
                            }


                },
                error  : function () 
                {
                    console.log("internal server error");
                }
            });
    });    //Cambiar estado del informe del estudio
    
    
    function guardarInformeYredireccionarAIndex(){
            var forminforme = $("#form-informe-complete");
             // submit form
              var url = 'index.php?r=informe/finalizarcarga';
            $.ajax({
                url    : url ,
                type   : "post",
                data   : forminforme.serialize(),
                success: function (response) 
                {

                },
                error  : function () 
                {
                    console.log("internal server error");
                }
          });
    	  
    }
    
    function guardarInforme(){
        var forminforme = $("#form-informe-complete");
  	    // submit form
  	    var url = 'index.php?r=informe/update&id='+forminforme.find("input#informe-id.form-control").val();;
        $.ajax({
            url    : url ,
            type   : "post",
            data   : forminforme.serialize(),
            success: function (response) 
            {

            },
            error  : function () 
            {
                console.log("internal server error");
            }
        });
      
    }

    $('.guardarTexto').click(function (e) {
            e.preventDefault(); 
            $('#modal').find('.modal-header').html('Nuevo Autotexto');
            var url = 'index.php?r=textos/create';
            var forminforme = $("#form-informe-complete");    
            bootbox.dialog({
                message: '¿Confirma que desea crear un nuevo autotexto a partir de este informe?',
                title: 'Sistema LABnet',
                className: 'modal-info modal-center',
                buttons: {
                        success: {
                            label: 'Aceptar',
                            className: 'btn-primary',
                            callback: function() {
                                $.ajax({
                                    url    : url ,
                                    type   : "post",
                                    data   : forminforme.serialize(),
                                    dataType: "JSON",
                                    success: function (response) 
                                    { 
                                        $('#modalContentAutotexto').html(response.data);     
                                        $('#modal').find('#modalContent').addClass('modal-autotexto');
                                        $('#modal').modal('show');
                                        $('#modal').focus();
                                        bootbox.hideAll();                                                                         
                                    },
                                    error  : function () 
                                    {
                                        console.log("internal server error");
                                    }
                                });                            
                            }
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-danger',                                     
                        }                                  
                    }
                });
            
            
        });  //Guardado de AutoTexto a partir de informe

    $("#idFile").on('fileuploaded', function(event) {
        $.pjax.reload({container:"#galeriar"});
    });

    
    $(document).on('ready pjax:success', function () {
        $('.change-estado').unbind();
        $('.change-estado').on('click', function () {
            var $estado = $(this).data('estado');
            var $informe = $(this).data('informe');
            var $workflow = $(this).data('workflow');
            var $workflow = $(this).data('usuario');
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10) {
                dd='0'+dd
            }
            if(mm<10) {
                mm='0'+mm
            }
            $today = yyyy +'-'+ mm+'-'+dd;
            //document.write(today);
            $url = 'index.php?r=workflow/updatestados';
            $.ajax({
                url    : $url,
                type   : "post",
                dataType: "JSON",
                data: { 'id' : $workflow,
                    'estado' : $estado,
                    'Workflow[fecha_fin]' : $today,
                    'Workflow[Informe_id]': $informe,
                    'Workflow[Responsable_id]': $workflow
                },
                success: function (response)
                {
                    if (response.result == 'ok'){
                        $.pjax.reload({container:"#estado"});
                        var n = noty({
                            text: response.mensaje,
                            type: 'success',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: true, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                            killer: true
                        });
                    }else if (response.result == 'error'){
                        var n = noty({
                            text: response.mensaje,
                            type: 'success',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: true, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                            killer: true
                        });
                    }
                },
                error  : function ()
                {
                    console.log("internal server error");
                }
            });
        });    //Cambiar estado del informe del estudio
   
        $('.kv-upload-progress').change(function(){
           alert('event.data'); 
        });

        $(".verInforme").click(function(e){ 
            e.preventDefault();
            $('#detalleInforme').load($(this).attr('value'));
            $('#popoverInforme').popover('show');
            $('[data-toggle="popover"]').popover('show');
        });


        $("#idFile").on('fileuploaded', function(event) {
            $.pjax.reload({container:"#galeriar"});
        });

        $("body").on("submit", "form#create-autotexto-form", function (e) {
                $("body").keydown(function(event){
                    if(event.keyCode == 13) {
                            event.preventDefault();
                            return false;
                    }
                });

                e.preventDefault();
                e.stopImmediatePropagation();
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

                            if (response.rdo == 'ko'){
                                var n = noty({
                                    text: 'El código debe ser único',
                                    type: 'error',
                                    killer: true,
                                    class: 'animated pulse',
                                    layout: 'topRight',
                                    theme: 'relax',
                                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                                });
                                return false;
                            }

                            else {
                             //   $.pjax.reload({container:'#pjax-tree'});
                                $("#modal").modal("toggle");

                                //   $.pjax.reload({container:"#pacientes"}); //for pjax update
                                var n = noty({
                                       text: 'Autotexto generado con éxito!',
                                       type: 'success',
                                       class: 'animated pulse',
                                       layout: 'topRight',
                                       theme: 'relax',
                                       killer: true,
                                       timeout: 3000, // delay for closing event. Set false for sticky notifications
                                       force: false, // adds notification to the beginning of queue when set to true
                                       modal: false, // si pongo true me hace el efecto de pantalla gris
                                });
                                   $.pjax.reload({container:"#pjax-container"});
                            }
                        },
                        error  : function () {
                            console.log("internal server error");
                        }
                });
            return false;
        });
        

        $('.deleteNomenclador').on('click', function (e) {
            var $id = $(this).attr('id');
            var $url = 'index.php?r=informe-nomenclador/delete'; 
            $.ajax({
                    type: "POST",
                    url: $url,               
                    dataType: "JSON",
                    data:  { 'id' : $id }, 
                    success: function(response) {                     

                        if (response.rta == 'success') {
                            $.pjax.reload({container:"#nomencladores"});
                            var n = noty({
                                text: response.message,
                                type: response.rta,
                                class: 'animated pulse',
                                layout: 'topRight',
                                theme: 'relax',
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force: false, // adds notification to the beginning of queue when set to true
                                modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                        }else{
                            var n = noty({
                                text: response.message,
                                type: response.rta,
                                class: 'animated pulse',
                                layout: 'topRight',
                                theme: 'relax',
                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                force: false, // adds notification to the beginning of queue when set to true
                                modal: false, // si pongo true me hace el efecto de pantalla gris
                            });
                        }

                       }
                  });
           });  //Borrar nomenclador
        
    });    //Cargado de eventos despues de un Pjax
          
    $( document ).ready(function(e) {
    	  setInterval(guardarInforme(), 20000);
    } );

    
    
    
