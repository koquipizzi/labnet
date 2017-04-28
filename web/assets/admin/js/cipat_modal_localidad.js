
            $("body").on("beforeSubmit", "form#create-localidad-form", function () {
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

                                $("#activity-modal").modal("toggle");
                                $.pjax.reload({container:"#localidad"}); //for pjax update
                                var n = noty({
                                    text: 'Entidad guardada con éxito!',                               
                                    type: 'success',
                                    class: 'animated pulse',
                                    layout      : 'topRight',
                                    theme       : 'relax',
                                    timeout: 2000, // delay for closing event. Set false for sticky notifications
                                    force: false, // adds notification to the beginning of queue when set to true
                                    modal: false, // si pongo true me hace el efecto de pantalla gris
                             //       maxVisible  : 10
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
                $('#activity-modal').addClass('modal-primary');
                $('.loadMainContent').click(function(){ // alert("lpm");
                    $('#activity-modal').find('.modal-header').html('Nueva Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
                
                $('.editar').click(function(){       
                    $('#activity-modal').find('.modal-header').html('Editar Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
                
                $('.ver').click(function(){       
                    $('#activity-modal').find('.modal-header').html('Ver Localidad');
                    $('#activity-modal').find('#modalContent').load($(this).attr('value'));
                    $('#activity-modal').modal('show');
                });
            });
