/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$(function () { 
//    
//});
            $("body").on("beforeSubmit", "form#create-nomenclador-form", function () {
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

                                $("#modal").modal("toggle");
                                $.pjax.reload({container:"#nomenclador"}); //for pjax update
                                var n = noty({
                                    text: 'Entidad agregada con éxito!',
                                    type: 'success',
                                    class: 'animated pulse',
                                    layout: 'topRight',
                                    theme: 'relax',
                                    timeout: 3000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                                });
                            },
                            error  : function () 
                            {
                                console.log("internal server error");
                            }
                        });
                        return false;
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
                    $('#modal').find('.modal-header').html('Editar Nomenclador');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
                $('.verPrestadora').click(function(e){  
                    e.preventDefault();
                    $('#modal').find('.modal-header').html('Detalles Prestadora');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
                $('.ver').click(function(e){  
                    e.preventDefault();
                    $('#modal').find('.modal-header').html('Ver Nomenclador');
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
