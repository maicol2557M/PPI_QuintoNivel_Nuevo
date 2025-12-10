$(document).ready(function(){
    $('.tooltips-general').tooltip('hide');

    // Variable para rastrear el estado del menú
    var menuState = 'open';

    // Inicializar el estado del menú
    function initializeMenu() {
        var NavLateral = $('.navbar-lateral');

        // Asegurar que el menú esté en la posición correcta al cargar
        NavLateral.css('left', '0');
        menuState = 'open';
    }

    // Ejecutar inicialización
    initializeMenu();

    $('.desktop-menu-button').on('click', function(e){
        e.preventDefault();
        var NavLateral=$('.navbar-lateral');
        var ContentPage=$('.content-page-container');

        // Funcionalidad sincronizada - usar clases CSS para que todo se mueva al mismo tiempo
        if(menuState === 'open'){
            // Cerrar menú - aplicar clases CSS que mueven todo al mismo tiempo
            NavLateral.addClass('desktopMenu');
            ContentPage.addClass('desktopMenu');
            menuState = 'closed';
        }else{
            // Abrir menú - quitar clases CSS que mueven todo al mismo tiempo
            NavLateral.removeClass('desktopMenu');
            ContentPage.removeClass('desktopMenu');
            menuState = 'open';
        }
    });
    $('.dropdown-menu-button').on('click', function(e){
        e.preventDefault();
        var icon=$(this).children('.icon-sub-menu');
        if(icon.hasClass('zmdi-chevron-down')){
            icon.removeClass('zmdi-chevron-down').addClass('zmdi-chevron-up');
            $(this).addClass('dropdown-menu-button-active');
        }else{
            icon.removeClass('zmdi-chevron-up').addClass('zmdi-chevron-down');
            $(this).removeClass('dropdown-menu-button-active');
        }

        var dropMenu=$(this).next('ul');
        dropMenu.slideToggle('slow');
    });
    $('.exit-system-button').on('click', function(e){
    e.preventDefault();

    swal({
        title: "¿Estás seguro?",
        text: "Quieres salir del sistema y cerrar la sesión actual",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Sí, salir",
        cancelButtonText: "No, cancelar",
        animation: "slide-from-top",
        closeOnConfirm: true
    }, function(){
        // Enviamos el formulario POST de logout
        document.getElementById('logout-form').submit();
    });
});
    $('.search-book-button').click(function(e){
        e.preventDefault();
        var LinkSearchBook=$(this).attr("data-href");
        swal({
           title: "¿Qué libro estás buscando?",
           text: "Por favor escribe el nombre del libro",
           type: "input",
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escribe aquí el nombre de libro" },
      function(inputValue){
           if (inputValue === false) return false;

           if (inputValue === "") {
               swal.showInputError("Debes escribir el nombre del libro");
               return false;
           }
            window.location=LinkSearchBook+"?bookName="+inputValue;
       });
    });
    $('.btn-help').on('click', function(){
        $('#ModalHelp').modal({
            show: true,
            backdrop: "static"
        });
    });
});

(function($){
    $(window).load(function(){
        $(".nav-lateral-scroll").mCustomScrollbar({
            theme:"light-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons:{ enable: true }
        });
        $(".custom-scroll-containers").mCustomScrollbar({
            theme:"dark-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons:{ enable: true }
        });
    });
})(jQuery);

$('.navbar-lateral').on('fadeOut', function(){
    console.log('¡Alguien llamó fadeOut en navbar-lateral!');
});
