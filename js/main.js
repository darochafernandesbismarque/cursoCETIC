$(document).ready(function(){
    $('.tooltips-general').tooltip('hide');
    $('.popover-general').popover('hide');
    $('.btn-help').on('click', function(){
        $('#ModalHelp').modal({
            show: true,
            backdrop: "static"
        });
    });
    $('.mobile-menu-button').on('click', function(){
        var mobileMenu=$('.navbar-lateral');	
        if(mobileMenu.css('display')=='none'){
            mobileMenu.fadeIn(300);
        }else{
            mobileMenu.fadeOut(300);
        }
    });
	$('.desktop-menu-button').on('click', function(e){
        e.preventDefault();
        var NavLateral=$('.navbar-lateral'); 
        var ContentPage=$('.content-page-container');   
        if(NavLateral.hasClass('desktopMenu')){
            NavLateral.removeClass('desktopMenu');
            ContentPage.removeClass('desktopMenu');
        }else{
            NavLateral.addClass('desktopMenu');
            ContentPage.addClass('desktopMenu');
        }
    });
    $('.dropdown-menu-button').on('click', function(){
        var dropMenu=$(this).next('ul');
        dropMenu.slideToggle('slow');
    });
    $('.exit-system-button').on('click', function(e){
        e.preventDefault();
        var LinkExitSystem=$(this).attr("data-href");
        swal({
            title: "Está Seguro?",
            text: "Deseja sair do sistema?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "Sair",
            cancelButtonText: "Cancelar",
            animation: "slide-from-top",
            closeOnConfirm: false 
        },function(){
            window.location=LinkExitSystem; 
        });  
    });
    $('.search-rg-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='devolver_arma_cautela.php'+"?rg="+inputValue;
       });
    });
	$('.search-emg-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='arma_cautelaemg.php'+"?rg="+inputValue;
       });
    });
	$('.search-recolhe-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='recolhimento_arma_cautela.php'+"?rg="+inputValue;
       });
    });
	$('.search-devolvearma-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='dev_recolhimento_arma_cautela.php'+"?rg="+inputValue;
       });
    });
	$('.search-codigo-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Posicione o Leitor no Código de Barra",
           text: "Por favor, Posicione o Leitor no Código de Barra",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='devolver_arma_cautela.php'+"?nr_arma="+inputValue;
       });
    });
	$('.search-barra-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o Número da Arma",
           text: "Por favor, digite os Números de Armas separados por virgulas e sem Espaço",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva a Alfanumérica da Arma" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever a Alfanumérica da Arma");     
               return false;   
           } 
            window.location='php_barcode/barcode.php'+"?nr_arma="+inputValue;
       });
    });

    $('.search-barras-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Posicione o Leitor no Código de Barra",
           text: "Por favor, Posicione o Leitor ou Digite o Número da Arma",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Posicione o Leitor" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve Posicionar o Leitor");     
               return false;   
           } 
            window.location='consultar_armabarra.php'+"?nr_arma="+inputValue;
       });
    });
	$('.search-armanumero-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o Número da Arma",
           text: "Por favor, digite o Número de Arma",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Posicione o Leitor" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve Posicionar o Leitor");     
               return false;   
           } 
            window.location='consultar_armanumero.php'+"?nr_arma="+inputValue;
       });
    });
    
    $('.search-colete-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='acautela_colete.php'+"?rgcautela1="+inputValue;
       });
    });
     
	 $('.search-devolve-button').click(function(e){
        e.preventDefault();
        
       swal({
           title: "Digite o RG do Policial Militar",
           text: "Por favor, digite o RG do Policial sem Ponto",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o RG do Policial" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o RG do Policial");     
               return false;   
           } 
            window.location='devolver_colete_cautela.php'+"?rgcautela="+inputValue;
       });
    });

   $('.search-devolve-arma-button').click(function(e){
        e.preventDefault();
        
       swal({
           title: "Digite o Nº da Arma",
           text: "Por favor, digite o Nº da Arma",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva o Nº da Arma" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o Nº da Arma");     
               return false;   
           } 
            window.location='devolver_arma_cautela.php'+"?nr_arma="+inputValue;
       });
    });
	$('.search-editar-arma-button').click(function(e){
        e.preventDefault();
        
       swal({
           title: "Digite o Nº da Arma",
           text: "Por favor, digite o Nº da Arma",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva o Nº da Arma" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o Nº da Arma");     
               return false;   
           } 
            window.location='editar_arma.php'+"?nr_arma="+inputValue;
       });
    });
	 $('.search-consultacautela-button').click(function(e){
        e.preventDefault();
        
        swal({
           title: "Digite o Número do Colete",
           text: "Por favor, digite o Número do Colete",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escreva aqui o Número do Colete" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Deve escrever o Número do Colete");     
               return false;   
           } 
            window.location='consulta_colete.php'+"?nr_colete="+inputValue;
       });
    });

    $('.tile').on('click', function(){
        var urlTile=$(this).attr('data-href');
        var numFile=$(this).attr('data-num');
        if(numFile>0){
            window.location=urlTile;
        }else{
            swal("Não há Armamentos em Uso");
        }
    });
    $('.footer-social').on('click', function(){
        var link=$(this).attr('data-link');
        window.open(link,"_blank");
    });
    $('.btn-addBook').on('click', function(e){
        e.preventDefault();
        var dir=$(this).attr('data-href');
        var url=$(this).attr('data-process');
        $.ajax({
            url:url,
            success:function(data){
                if(data==="Avaliable"){
                    window.location=dir;
                }else if (data==="NotAvaliable"){
                    swal({
                       title:"Opcão não disponível!",
                       text:"Vê a Opcão Administrador do Menu",
                       type: "error",
                       confirmButtonText: "Acessar"
                    });
                }else{
                    swal({
                       title:"Ocoreu um Erro inesperado!",
                       text:"Hemos tenido un error al tratar de acceder a esta sección, por favor recarga la página e intenta nuevamente",
                       type: "error",
                       confirmButtonText: "Acessar"
                    });
                }
            }
        });
    });
    $('.btn-update').on('click', function(){
        var code=$(this).attr('data-code');
        var url=$(this).attr('data-url');
        $.ajax({
            url:url,
            type: 'POST',
            data: 'code='+code,
            success:function(data){
                $('#ModalData').html(data);
                $('#ModalUpdate').modal({
                    show: true,
                    backdrop: "static"
                });
            }
        });
        return false;
    });
});
(function($){
    $(window).load(function(){
        $(".custom-scroll-containers").mCustomScrollbar({
            theme:"dark-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons:{ enable: true }
        });
    });
})(jQuery);