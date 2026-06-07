/* =========================================================
   TOGGLEPASSWORD.JS
   Activa el icono de "ojo" para mostrar/ocultar la contraseña.
   ========================================================= */


/**
 * Busca todos los botones con clase .btn-toggle-password en la página
 * y les añade el comportamiento de cambiar el tipo del input asociado
 * entre 'password' (oculto) y 'text' (visible).
 *
 * El botón debe llevar el atributo data-target="idDelInput"
 * Ejemplo en HTML:
 *   <input type="password" id="miPassword">
 *   <button class="btn-toggle-password" data-target="miPassword">
 *       <i class="bi bi-eye"></i>
 *   </button>
 *
 * Se llama automáticamente al cargar la página desde iniciador.js
 */
function inicializarBotonesOjo() {
    // Buscamos TODOS los botones con esa clase
    var botones = document.querySelectorAll('.btn-toggle-password');

    // Recorremos cada uno y le añadimos un listener de click
    botones.forEach(function (btn) {

        btn.addEventListener('click', function () {

            // Leemos el atributo data-target para saber qué input controlar
            // <button data-target="password">  →  targetId = "password"
            var targetId = btn.getAttribute('data-target');

            // Buscamos el input correspondiente
            var input = document.getElementById(targetId);
            if (!input) return; // Si no existe, salimos

            // Comprobamos su tipo actual
            var esPassword = (input.type === 'password');

            // Si era password lo ponemos como text (se ve)
            // Si era text lo ponemos como password (se oculta)
            input.type = esPassword ? 'text' : 'password';

            // Cambiamos el icono del ojo: cerrado ↔ abierto
            var icono = btn.querySelector('i');
            if (icono) {
                // toggle: si tiene la clase la quita, si no la tiene la añade
                icono.classList.toggle('bi-eye');
                icono.classList.toggle('bi-eye-slash');
            }

            // Actualizamos el aria-label para accesibilidad (lectores de pantalla)
            btn.setAttribute(
                'aria-label',
                esPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );
        });
    });
}


/* =========================================================
   Cuando el HTML está listo, activamos:
     - Botones ojo (mostrar/ocultar contraseña)
     - Tooltips de Bootstrap
     - Popovers de Bootstrap
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    // Botones de mostrar/ocultar contraseña
    inicializarBotonesOjo();

    // Tooltips de Bootstrap (los mensajitos al pasar el ratón)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }

});
