/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$(function () { 

        $('.addInforme').click(function(e){
            var form = $("#create-informeTemp-form");
            if ($("#informetemp-estudio_id").val()=="") {   
                $('.field-informetemp-estudio_id').addClass(' has-error');  
                        return false;
            }else{
                $('.field-informetemp-estudio_id').removeClass(' has-error');    
                $('.field-informetemp-estudio_id').addClass('has-success');  
            }
            
            if (form.find(".has-error").length)
                {
                    return false;
                }
            
            // submit form
            $.ajax({ 
                url : 'index.php?r=informetemp/create',
                type : "post",
                dataType: "JSON",
                data : form.serialize(),
                success: function (response)
                {
                  //  alert(response);
                 //   $("#activity-modal").modal("toggle");
              //   $.pjax.reload({container:'#estudios'});
                    $('#estudiosInformeTemp').html(response.data); //for pjax update
                    $('#informetemp-tanda').val(response.tanda);
                    $('#hiddenInformeTemp').val(response.tanda);
                    $('#agregarEstudio').toggle();
                    $('.summary').toggle();
                   // $('#descripcion').val("");
                    $('#informetemp-observaciones').val("");
                    $('#informetemp-descripcion').val("");
                    $(".select2-choices .select2-search-choice").remove();
                    $("#s2-togall-nomenclador-servicio").html("");
               
                    
                    $("#nomenclador-servicio").val("");
                    
                    
                    $("#informetemp-estudio_id").val('');
                    $('.field-informetemp-estudio_id').removeClass('has-success');   
//                     $('#selector-servicio_refresh').val("");
//                     $('#selector-servicio_refresh').load(" <?php echo $this->render('selecNomencladores', ['nomenclador' => $nomenclador,]) ?>");
                },
                error : function (response)
                {
                    alert(response.mensaje);
                    console.log("internal server error");
                }
                });
                return false;
        });

        function send(){
            alert('ddddd');
                //agregar el campo tanda al modelo            
                var form = $("#create-informeTemp-form");


         
               if ($("#informetemp-estudio_id").val()=="") {   
                      $('.field-informetemp-estudio_id').addClass(' has-error');  
                        return false;
                }else{
                   $('.field-informetemp-estudio_id').removeClass(' has-error');    
                    $('.field-informetemp-estudio_id').addClass('has-success');  
                }
             
                if (form.find(".has-error").length)
                     {
                         return false;
                     }
                // submit form
                $.ajax({ 
                url : 'index.php?r=informetemp/create',
                type : "post",
                dataType: "JSON",
                data : form.serialize(),
                success: function (response)
                {
                  //  alert(response);
                 //   $("#activity-modal").modal("toggle");
              //   $.pjax.reload({container:'#estudios'});
                    $('#estudiosInformeTemp').html(response.data); //for pjax update
                    $('#informetemp-tanda').val(response.tanda);
                    $('#hiddenInformeTemp').val(response.tanda);
                    $('#agregarEstudio').toggle();
                    $('.summary').toggle();
                   // $('#descripcion').val("");
                    $('#informetemp-observaciones').val("");
                    $('#informetemp-descripcion').val("");
                    $(".select2-choices .select2-search-choice").remove();
                    $("#s2-togall-nomenclador-servicio").html("");
               
                    
                    $("#nomenclador-servicio").val("");
                    
                    
                    $("#informetemp-estudio_id").val('');
                    $('.field-informetemp-estudio_id').removeClass('has-success');   
//                     $('#selector-servicio_refresh').val("");
//                     $('#selector-servicio_refresh').load(" <?php echo $this->render('selecNomencladores', ['nomenclador' => $nomenclador,]) ?>");
                },
                error : function ()
                {

                    console.log("internal server error");
                }
                });
                return false;
        };  
            



        function registrarPago(){
                //agregar el campo tanda al modelo            
                var form = $("#gridFacturable");
                // submit form
                $.ajax({ 
                url : 'index.php?r=pago/create',
                type : "post",
                dataType: "JSON",
                data : form.serialize(),
                success: function (response)
                {
                    
                },
                error : function ()
                {

                    console.log("internal server error");
                }
                });
                return false;
        };  



        function search(){
            
    
                //agregar el campo tanda al modelo            
                var form = $("#searchForm");
                
                // submit form
                $.ajax({ 
                url : 'index.php?r=site/search',
                type : "post",
                dataType: "JSON",
                data : form.serialize(),
                success: function (response)
                {
                    console.log("entre ajax");
                },
                error : function ()
                {

                    console.log("internal server error");
                }
                });
                return false;
        };  

   $( document ).ready(function() {
       
         $("#pago-prestadoras_id").on('change', function() {
            var form = new FormData();
            var selectPrestadora= $("#pago-prestadoras_id").val();    
            var fechaDesde= $("#pago-fecha_desde").val();    
            var fechaHasta= $("#pago-fecha_hasta").val();    
            
            form.append("prestadoras_id" ,selectPrestadora);
            form.append("fechaDesde" ,fechaDesde);
            form.append("fechaHasta" ,fechaHasta);

            $.ajax({ 
                url : 'index.php?r=pago/createpartial',
                type : "post",
                dataType: "JSON",
                data : form,
                processData: false,
                contentType: false,
                success: function (response)
                {
                    $('#grillaPago').html(response.data);

                },
                error : function ()
                {

                    console.log("internal server error");
                }
            });
                return false;
        })
                
});          
      
   $( document ).ready(function() {
        $("#pago-fecha_desde").on('change', function() {
            var form = new FormData();
            var selectPrestadora= $("#pago-prestadoras_id").val();    
            var fechaDesde= $("#pago-fecha_desde").val();    
            var fechaHasta= $("#pago-fecha_hasta").val();    
            
            form.append("prestadoras_id" ,selectPrestadora);
            form.append("fechaDesde" ,fechaDesde);
            form.append("fechaHasta" ,fechaHasta);
            $.ajax({ 
                url : 'index.php?r=pago/createpartial',
                type : "post",
                dataType: "JSON",
                data : form,
                processData: false,
                contentType: false,
                success: function (response)
                {
                    $('#grillaPago').html(response.data);

                },
                error : function ()
                {

                    console.log("internal server error");
                }
            });
                return false;
        })
                
});          
            
    $( document ).ready(function() {
         $("#pago-fecha_hasta").on('change', function() {
            var form = new FormData();
            var selectPrestadora= $("#pago-prestadoras_id").val();    
            var fechaDesde= $("#pago-fecha_desde").val();    
            var fechaHasta= $("#pago-fecha_hasta").val();    
            
            form.append("prestadoras_id" ,selectPrestadora);
            form.append("fechaDesde" ,fechaDesde);
            form.append("fechaHasta" ,fechaHasta);
            $.ajax({ 
                url : 'index.php?r=pago/createpartial',
                type : "post",
                dataType: "JSON",
                data : form,
                processData: false,
                contentType: false,
                success: function (response)
                {
                    $('#grillaPago').html(response.data);

                },
                error : function ()
                {

                    console.log("internal server error");
                }
            });
                return false;
        })
                
});      
      

                
      $( document ).ready(function() {             
         $("body").on("beforeSubmit", "form#createPago", function () {
        var form = new FormData(this);
        var checkboxValues = new Array();
        $('input[type="checkbox"]:checked').each(function() {
                checkboxValues.push($(this).val());
        });
        
        var countProtocolos= $('div.summary').children('b').last().text();
         form.append("protocolo" , checkboxValues);
         form.append("countProtocolos" , countProtocolos);
         $.ajax({
                url    : $(this).attr("value"),
                type   : "post",
                data   : form,
                processData: false,
                contentType: false,
                success: function (response) 
                {
                    if(response.rta==='error'){
                      
                    //    $.pjax.reload({container:"#pacientes"}); //for pjax update
                        var n = noty({
                            text: "Error, debe seleccionar al menos un informe u protocolo",
                            type: 'success',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: false, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                        });
                    }else{
                            var n = noty({
                                text: "El pago fue asentado correctamente",
                                type: 'success',
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
                      });         
                
        function addEstudio(){
            $('#agregarEstudio').toggle();
        };
            
        $("body").on("beforeSubmit", "form#form-protocolo", function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find(".has-error").length) 
                return false;
            // submit form
            $.ajax({
                url    : form.attr("action"),
                type   : "post",
                data   : form.serialize(),
                success: function (response) 
                {
              
                    if(response.rta==='error'){
                      
                    //    $.pjax.reload({container:"#pacientes"}); //for pjax update
                        var n = noty({
                            text: "Error, debe cargar al menos un estudio",
                            type: 'error',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: false, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                        });
                    }else{
                     
                        var n = noty({
                            text: "El protocolo fue creado correctamente",
                            type: 'success',
                            class: 'animated pulse',
                            layout: 'topRight',
                            theme: 'relax',
                            timeout: 3000, // delay for closing event. Set false for sticky notifications
                            force: false, // adds notification to the beginning of queue when set to true
                            modal: false, // si pongo true me hace el efecto de pantalla gris
                        });
                          $.pjax.reload({container:"#trab__prot_pendientes"}); //for pjax update
                    }
               },
                error  : function () 
                {
                    console.log("internal server error");
                }
            });
            return false;
            });



            $(document).on('ready pjax:success', function () {             
                
                $('#addInforme').click(function(e){                    
                    e.preventEvent();                
                });
                
                $('.editar').click(function(e){  
                   window.location = $(this).attr('value');
  
                });
                
                $('.protoClass').click(function(e){  
                    $('#modal').find('.modal-header').html('Editar Estudio');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
                $('.ver').click(function(e){  
                    $('#modal').find('.modal-header').html('Ver Estudio');
                    $('#modal').find('#modalContent').load($(this).attr('value'));
                    $('#modal').modal('show');
                });
                
                $('.borrar').click(function(e){
                    e.preventDefault();
                    var $urlw = $(this).attr("value");
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar Paciente?',
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
                                            $.pjax.reload({container: '#pacientes'});
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
                
            
                 $('.deleteInformeTemp').click(function(e){  
                    $('#estudiosInformeTemp').load($(this).attr('value'));
                
                });
                
                         
 });
 function deleteInformetemp($id, $url_post){       
                var $informe_id = $id;
                var $url;
                if ($url_post.search('informetemp') >= 0) //viene de nuevo
                    $url = 'index.php?r=informetemp/delete&id='+ $informe_id; 
//                else $url =  'index.php?r=informetemp/delete&id='+ $Paciente_id;                 
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar el Estudio?',
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
                                            beforeSend: function() {
                                                 $('tr[data-key='+$informe_id+']').text('Eliminando...');
                                            },
                                            success: function ()
                                                {
//                                                    $.pjax.reload({container:"#prestadoras"});
                                                    $('tr[data-key='+$informe_id+']').remove(); //for pjax update
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
            
            
            
 function deleteInforme($id, $url_post){   

                var $informe_id = $id;
                var $url;
                if ($url_post.search('informetemp') >= 0) //viene de nuevo
                    $url = 'index.php?r=informe/delete&id='+ $informe_id; 
//                else $url =  'index.php?r=informetemp/delete&id='+ $Paciente_id;                 
                    bootbox.dialog({
                              message: '¿Confirma que desea eliminar el Estudio?',
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
                                            beforeSend: function() {
                                                 $('tr[data-key='+$informe_id+']').text('Eliminando...');
                                            },
                                            success: function ()
                                                {
//                                                    $.pjax.reload({container:"#prestadoras"});
                                                    $('tr[data-key='+$informe_id+']').remove(); //for pjax update
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
 $(document).on('ready pjax:success', function () {   
    $('.finalizado').on('click', function (e) {
        e.preventDefault();
        var $url =$(this).attr('href'); 
        $.ajax({
                type: "GET",
                url: $url,               
                dataType: "JSON",
                success: function(response) {  
                    if(response.rta=='error'){                   
                        var n = noty({
                                type: 'success',
                                text:  response.message,
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
                             
                    }
                }
            });
            
        });
        
       
 });

              