 //         $('.form-protocolo').data('yiiActiveForm').submitting = false; hay que setearlo para q despes no quiera mandarlo
$( document ).ready(function(e) {
            $('.loadMainContentInformeTemp').click(function(){ 
                   
               $('#activity-modal').find('.modal-header').html('Nuevo Informe');
               $('#activity-modal').find('#InformeData').load($(this).attr('value'));
               $('#activity-modal').modal('show');
            });

} );