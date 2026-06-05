/* 
   Lógica del formulario de dejar opinión:
     - Sistema de estrellas interactivo (click + hover).
     - Validación al enviar el formulario.
*/
document.addEventListener('DOMContentLoaded', function () {

    // ----- 1) Sistema de estrellas interactivo -----
    var contEstrellas = document.getElementById('estrellas');
    var estrellas     = document.querySelectorAll('#estrellas label.estrella');

    // Al hacer click en una estrella, marcar el radio y colorearla
    estrellas.forEach(function (label, idx) {
        label.addEventListener('click', function () {
            estrellas.forEach(function (l, i) {
                l.style.color = (i <= idx) ? '#f5b301' : '#ddd';
            });
        });

        // Hover: previsualizar el coloreado
        label.addEventListener('mouseenter', function () {
            estrellas.forEach(function (l, i) {
                l.style.color = (i <= idx) ? '#f5b301' : '#ddd';
            });
        });
    });

    // Si el ratón sale del grupo, volver al estado real (radio seleccionado)
    contEstrellas.addEventListener('mouseleave', function () {
        var radio = document.querySelector('input[name=puntuacion]:checked');
        var seleccionado = radio ? parseInt(radio.value) - 1 : -1;
        estrellas.forEach(function (l, i) {
            l.style.color = (i <= seleccionado) ? '#f5b301' : '#ddd';
        });
    });


    // ----- 2) Validación del formulario al enviar -----
    document.getElementById('formOpinion').addEventListener('submit', function (e) {
        var radio      = document.querySelector('input[name=puntuacion]:checked');
        var comentario = document.getElementById('comentario');
        var ok = true;

        if (!radio) {
            alert('Selecciona una puntuación.');
            ok = false;
        }

        if (comentario.value.trim().length < 10) {
            mostrarError(comentario, 'Mínimo 10 caracteres.');
            ok = false;
        } else {
            mostrarOk(comentario);
        }

        if (!ok) e.preventDefault();
    });

});
