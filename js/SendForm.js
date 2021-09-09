$(document).ready(function(){
    var MsjErrorSending='<div class="responseProcess"><div class="container-loader"><div class="loader"><i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i></div><p class="text-center lead">Ocorreu um Problema, Recargue a Pagina e Tente Novamente Presionando F5</p></div></div>';
    var MsjSending='<div class="responseProcess"><div class="container-loader"><div class="loader"><svg class="circular"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div><p class="text-center lead">Procesando... Un momento por favor</p></div></div>';
    $('.form_SRCB').submit(function(e) {
        e.preventDefault();
        var informacion=$(this).serialize();
        var metodo=$(this).attr('method');
        var peticion=$(this).attr('action');
        var type_form=$(this).attr('data-type-form');
        if(type_form==="login"){
            $.ajax({
                type: metodo,
                url: peticion,
                data:informacion,
                beforeSend: function(){
                    $('.msjFormSend').html(MsjSending);
                },
                error: function() {
                    $('.msjFormSend').html(MsjErrorSending);
                },
                success: function (data) {
                    $('.msjFormSend').html(data);
                }
            });
            return false;
        }else{
            var title_alert;
            var text_alert;
            var type_alert;
            var confirmButtonColor_alert;
            var confirmButtonText_alert;
            var closeAlert;
            if(type_form==="save"){
                title_alert="Deseja Salvar os Dados?";
                text_alert="Dados Serão Salvos no Sistema";
                type_alert="info";
                confirmButtonColor_alert="#3598D9";
                confirmButtonText_alert="Sim, Salvar";
                closeAlert=false;
            }
            if(type_form==="saveLoan"){
                title_alert="Confirmar a Devolucao";
                text_alert="Confirmar a Devolucao do Acessorio";
                type_alert="info";
                confirmButtonColor_alert="#16a085";
                confirmButtonText_alert="Sim, Confirmar";
                closeAlert=false;
            }
            if(type_form==="saveReservation"){
                title_alert="¿Quieres realizar la reservación?";
                text_alert="La reservación quedara registrada en el sistema con tus datos";
                type_alert="info";
                confirmButtonColor_alert="#3598D9";
                confirmButtonText_alert="Si, realizar";
                closeAlert=false;
            }
            if(type_form==="confirma"){
                title_alert="Confirmar Devolucao";
                text_alert="Confirma a Devolucao do Armamento";
                type_alert="warning";
                confirmButtonColor_alert="#C9302C";
                confirmButtonText_alert="Sim, Confirma";
                closeAlert=false;
            }
            if(type_form==="deleteReservation"){
                title_alert="¿Quieres eliminar la reservación?";
                text_alert="La reservación se eliminara de forma permanente";
                type_alert="warning";
                confirmButtonColor_alert="#C9302C";
                confirmButtonText_alert="Si, eliminar";
                closeAlert=false;
            }
            if(type_form==="update"){
                title_alert="Deseja Confirma o Consumo?";
                text_alert="Consumos Atualizados";
                type_alert="info";
                confirmButtonColor_alert="#16a085";
                confirmButtonText_alert="Si, atualizar";
                closeAlert=false;
            }
            if(type_form==="receiveLoan"){
                title_alert="Confirmar a Devolucao do Armamento";
                text_alert="Confirmar a Devolucao do Armamento";
                type_alert="info";
                confirmButtonColor_alert="#16a085";
                confirmButtonText_alert="Sim, Receber";
                closeAlert=false;
            }
             

            if(type_form==="approveReservation"){
                title_alert="¿Quieres aprobar el préstamo?";
                text_alert="La reservación será aprobada, y se cambiará a devoluciones pendientes";
                type_alert="info";
                confirmButtonColor_alert="#16a085";
                confirmButtonText_alert="Si, aprobar";
                closeAlert=false;
            }
            if(type_form==="updateAccounAdmin"){
                title_alert="¿Quieres realizar el cambio?";
                text_alert="Puedes activar o desactivar la cuenta del administrador en cualquier momento";
                type_alert="info";
                confirmButtonColor_alert="#16a085";
                confirmButtonText_alert="Si, realizar";
                closeAlert=false;
            }
            if(type_form==="restorePoint"){
                title_alert="¿Quieres restaurar el sistema?";
                text_alert="El sistema se restaurará al punto que has seleccionado. Ten en cuenta que se perderán todos los datos que no se hayan guardado en la copia de seguridad que has seleccionado";
                type_alert="warning";
                confirmButtonColor_alert="#286090";
                confirmButtonText_alert="Si, restaurar";
                closeAlert=true;
            }
            if(type_form==="deleteBackup"){
                title_alert="¿Quieres eliminar las copias?";
                text_alert="Todas las copias de seguridad del sistema se eliminarán permanentemente y no podrás recuperarlas";
                type_alert="warning";
                confirmButtonColor_alert="#C9302C";
                confirmButtonText_alert="Si, eliminar";
                closeAlert=false;
            }
            swal({
                title: title_alert,   
                text: text_alert,   
                type: type_alert,   
                showCancelButton: true,   
                confirmButtonColor: confirmButtonColor_alert,   
                confirmButtonText: confirmButtonText_alert,
                cancelButtonText: "Não, Cancelar",
                closeOnConfirm: closeAlert,
                animation: "slide-from-top"
            }, function(){
                $.ajax({
                    type: metodo,
                    url: peticion,
                    data:informacion,
                    beforeSend: function(){
                        $('.msjFormSend').html(MsjSending);
                    },
                    error: function() {
                        $('.msjFormSend').html(MsjErrorSending);
                    },
                    success: function (data) {
                        $('.msjFormSend').html(data);
                    }
                });
                return false;
            }); 
        }
    }); 
});
