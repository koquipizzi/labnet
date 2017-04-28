/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
            $('.crearProtocolo').click(function(e){
         
                $('#modal').find('.modal-header').html('Crear Protocolo');
                $('#modal').find('#modalContent').load($(this).attr('value'));
                $('#modal').modal('show');
            
                    
            });
                

            function crearProtocolo($id, $url_post){ 
                 $('#modal').find('.modal-header').html('Crear Protocolo');
                $('#modal').find('#modalContent').load($url_post);
                $('#modal').modal('show');
            }
            
            function deletePrestadora($id, $url_post){                              
                var $Paciente_id = $id;
                var $url;
                if ($url_post.search('prestadoratemp') >= 0) //viene de nuevo
                    $url = 'index.php?r=prestadoratemp/delete&id='+ $Paciente_id; 
                else $url =  'index.php?r=paciente-prestadora/delete&id='+ $Paciente_id;                 
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar Prestadora?',
                              title: 'Sistema LABnet',
                              className: 'modal-info modal-center',
                              buttons: {
                                    success: {
                                    label: 'Aceptar',
                                    className: 'btn-primary',
                                        callback: function() {
                                        $.ajax({ 
                                            url : $url,
                                            type : "POST",
                                          //  dataType: "JSON",
                                           // data: {'Paciente_id' : $id }, //("#PacienteId").val()},
                                            beforeSend: function() {
                                                 $('tr[data-key='+$Paciente_id+']').text('Eliminando...');
                                            },
                                            success: function ()
                                                {
//                                                    $.pjax.reload({container:"#prestadoras"});
                                                    $('tr[data-key='+$Paciente_id+']').remove(); //for pjax update
                                                },
                                            error : function ()
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
                    
            };
                
            function send_prestadora(){             
                $nro_afiliado = $("[name='PrestadoraTemp[nro_afiliado]']").val();
                if($nro_afiliado !== "" && $nro_afiliado !== null)
              {
                    $.ajax({ 
                        url : 'index.php?r=prestadoratemp/create',
                        type : "POST",
                        dataType: "JSON",
                        data: {'Prestadora_id' : $("[name='PrestadoraTemp[Prestadora_id]']").val(),
                            'nro_afiliado' : $("[name='PrestadoraTemp[nro_afiliado]']").val(),
                            'tanda' : $("[name='PrestadoraTemp[tanda]']").val()},
                        success: function (response)
                            {
                                $('#agregarPrestadora').toggle();
                                $("[name='PrestadoraTemp[nro_afiliado]']").val('');
                                $('#prestadorasTemp').html(response.data); //for pjax update
                                $('#hiddenPrestadoraTemp').val(response.tanda);
                            },
                        error : function ()
                            {
                                console.log("internal server error");
                            }
                        });
                }
                else {
                     bootbox.dialog({
                                message: 'Debe ingresar el número de afiliado del paciente.',
                                title: 'Sistema LABnet',
                                className: 'modal-info modal-center',
                                buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',                                      
                                  },
                                                                  
                                }
                            });     
                }
                return false;
            };  
                
            function send_prestadora_edit(){
             
                $nro_afiliado = $("[name='PrestadoraTemp[nro_afiliado]']").val();
                if($nro_afiliado !== "" && $nro_afiliado !== null)
              //  if ($nro_afiliado !== null)
                {
                    $.ajax({ 
                        url : 'index.php?r=paciente-prestadora/create',
                        type : "POST",
                        dataType: "JSON",
                        data: {'Prestadora_id' : $("[name='PrestadoraTemp[Prestadora_id]']").val(),
                            'nro_afiliado' : $("[name='PrestadoraTemp[nro_afiliado]']").val(),
                            'Paciente_id' : $("#PacienteId").val()},
                        success: function (response)
                            {
                                $('#agregarPrestadora').toggle();
                                $("[name='PrestadoraTemp[nro_afiliado]']").val('');
                                $('#prestadorasTemp').html(response.data); //for pjax update
                            },
                        error : function ()
                            {
                                console.log("internal server error");
                            }
                        });
                }
                else {
                     bootbox.dialog({
                                message: 'Debe ingresar el número de afiliado del paciente.',
                                title: 'Sistema LABnet',
                                className: 'modal-info modal-center',
                                buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',                                      
                                  },
                                                                  
                                }
                            });                    
                }
                
                
                
                return false;
            };  
                
            $("body").on("beforeSubmit", "form#create-prestadoraTemp-form", function () {                
                $nro_afiliado = $("[name='PrestadoraTemp[nro_afiliado]']").val();
                if($nro_afiliado !== "" && $nro_afiliado !== null)
                    send_prestadora();
                else send_prestadora_edit();
                $("#enviar_paciente").first().focus();
                return false;
             });

            $("body").on("beforeSubmit", "form#create-paciente-form", function () {
                $("body").keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                }); 
                
                $("#prestadoratemp-nro_afiliado").keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                }); 

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
                        $.pjax.reload({container:"#pacientes"}); //for pjax update
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
            
            function addPrestadora(){
                $('#agregarPrestadora').toggle();
            };

            function recargar_grilla($id){
                $.ajax({ 
                        url : 'index.php?r=paciente-prestadora/grilla',
                        type : "POST",
                        dataType: "JSON",
                        data: {'Paciente_id' : $id }, //("#PacienteId").val()},
                        beforeSend: function() {
                            $('#prestadorasTemp').html("<img class='mr-15' src='@web/assets/global/img/loader/general/3.gif' >");
                        },
                        success: function (response)
                            {
                                $('#prestadorasTemp').html(response.data); //for pjax update
                            },
                        error : function ()
                            {
                                console.log("internal server error");
                            }
                    });
            }

            $(document).on('ready pjax:success', function () { 
                
                $([name="fecha_nacimiento"]).removeClass("form-control");       
                
                $('.borrar').click(function(e){
                    e.preventDefault();
                    var $urlw = $(this).attr("value");
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar Paciente?',
                              title: 'Sistema LABnet',
                              className: 'modal-center',
                              buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',
                                      callback: function() {
                                        $.ajax($urlw, {
                                            type: 'POST',
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                              //  bootbox.alert('No se puede eliminar esa entidad.');   
                                              var n = noty({
                                                type: 'warning',
                                                text: 'No se puede eliminar la entidad seleccionada.',
                                                layout: 'topRight',
                                                theme: 'relax',
                                                timeout: 4000,
                                                animation: {
                                                    open: {height: 'toggle'},
                                                    close: {height: 'toggle'},
                                                    easing: 'swing',
                                                    speed: 500 // opening & closing animation speed
                                                }
                                            });                                     
                                            }
                                        }).done(function(data) {
                                            var n = noty({
                                                type: 'success',
                                                text: 'Entidad eliminada con éxito!',
                                                layout: 'topRight',
                                                theme: 'relax',
                                                timeout: 3000,
                                                animation: {
                                                    open: {height: 'toggle'},
                                                    close: {height: 'toggle'},
                                                    easing: 'swing',
                                                    speed: 500 // opening & closing animation speed
                                                }
                                            });        
                                            $.pjax.reload({container: '#pacientes'});
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
                
                $('.botonBorrarPrest').click(function(e){                    
                    e.preventDefault();
                    var $url = $(this).attr("value");
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar Prestadora?',
                              title: 'Sistema LABnet',
                              className: 'modal-info modal-center',
                              buttons: {
                                  success: {
                                      label: 'Aceptar',
                                      className: 'btn-primary',
                                      callback: function() {
                                        $.ajax($url, {
                                            type: 'POST',
                                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                                bootbox.alert('No se puede eliminar esa entidad.');                                    
                                            }
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#prestadorasTemp'});
                                            var n = noty({
                                                text: 'Entidad eliminada con éxito!',
                                                type: 'success',
                                                class: 'animated pulse',
                                                layout: 'topRight',
                                                theme: 'relax',
                                                timeout: 3000, // delay for closing event. Set false for sticky notifications
                                                force: false, // adds notification to the beginning of queue when set to true
                                                modal: false, // si pongo true me hace el efecto de pantalla gris
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
