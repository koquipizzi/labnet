
   $('.click').on('click', function (e) {    
        e.preventDefault();        
        var $url = 'index.php?r=informe-nomenclador/create'; 
        $p = $('#popNomenclador');       
        $p.popoverX('toggle');

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
                        $('#popNomenclador').popoverX('hide');
                    }else if(response.rta == 'error'){                        
                        $('.field-informenomenclador-cantidad').removeClass('has-success');
                        $('.field-informenomenclador-cantidad').addClass('has-error');
                        $('.field-informenomenclador-cantidad .help-block').html(response.message.cantidad[0]);
                    }                    
                    else {
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
                        $('#popNomenclador').popoverX('hide');
                    }
                }
           });
    });
       

            $(document).on('ready pjax:success', function () { 
                $('#modal').addClass('modal-primary');
                $('.loadMainContentNomenclador').click(function(){  
                    $('#modal').find('.modal-header').html('Nuevo Nomenclador');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
     
                
                $('.editar').click(function(e){  
                    e.preventDefault();
                    $('#modal').find('.modal-header').html('Editar');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
                $('.borrar').click(function(e){ 
                    e.preventDefault();
                    ion.sound.play('camera_flashing');
                    var $urlw = $(this).attr('value');
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar Nomenclador?',
                              title: 'Sistema LABnet',
                              className: 'modal-info modal-center',
                              buttons: {
                                  success: {
                                        label: 'Aceptar',
                                        className: 'btn-primary',
                                        callback: function() {
                                        $.ajax($urlw, {
                                            type: 'POST',
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                bootbox.alert('No se puede eliminar esa entidad.');                                    
                                            }
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#nomenclador'});
                                            var n = noty({
                                            text: 'Entidad eliminada con éxito!',
                                            type: 'success',
                                            class: 'animated pulse',
                                            layout: 'topRight',
                                            theme: 'relax',
                                            timeout: 2000, // delay for closing event. Set false for sticky notifications
                                            force: false, // adds notification to the beginning of queue when set to true
                                            modal: false, // si pongo true me hace el efecto de pantalla gris
                                     //       maxVisible  : 10
                                            });
                                        });                                        
                                      }
                                  },
                                  cancel: {
                                      label: 'Cancelar',
                                      className: 'btn-danger',                                     
                                  }                                  
                                }
                            });
                });
                                

 });
