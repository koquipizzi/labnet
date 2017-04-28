/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    
            $("body").on("beforeSubmit", "form#create-medico-form", function () {
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
                                $.pjax.reload({container:"#medicos"}); //for pjax update
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
                $.fn.modal.Constructor.prototype.enforceFocus = $.noop;
               
                
                
                


 });
