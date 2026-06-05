/* =========================================================
   SCROLL TO TOP - Botón flotante para volver arriba
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('scrollToTopBtn');
    if (!btn) return;

    // Mostrar/ocultar según el scroll
    window.addEventListener('scroll', function () {
        if (window.scrollY > 200) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    // Click: volver arriba suavemente
    btn.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
