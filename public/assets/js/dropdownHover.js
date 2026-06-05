
document.addEventListener('DOMContentLoaded', function () {

    // Solo activamos hover en pantallas medianas/grandes (>= 992px = lg)
    if (window.innerWidth < 992) return;

    var dropdowns = document.querySelectorAll('.nav-user-dropdown');

    dropdowns.forEach(function (dropdown) {
        var toggle = dropdown.querySelector('.dropdown-toggle');
        var menu   = dropdown.querySelector('.dropdown-menu');
        if (!toggle || !menu) return;

        // Al entrar el ratón → abrimos el menú
        dropdown.addEventListener('mouseenter', function () {
            menu.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
        });

        // Al salir el ratón → cerramos el menú
        dropdown.addEventListener('mouseleave', function () {
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
});
