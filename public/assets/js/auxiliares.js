/* =====================================================================
   AUXILIARES.JS
   ---------------------------------------------------------------------
   Funciones auxiliares reutilizables en toda la web para pintar
   feedback en los formularios (errores, aciertos, spinner del botón).
 ===================================================================== */


// Marca un campo como ERRÓNEO (borde rojo) y muestra un mensaje debajo
function mostrarError(input, mensaje) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');

    var feedback = input.parentElement.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.textContent = mensaje;
    }
}

// Marca un campo como CORRECTO (borde verde)
function mostrarOk(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
}

// Resetea el campo: ni rojo ni verde, neutral
function resetearInput(input) {
    input.classList.remove('is-invalid');
    input.classList.remove('is-valid');
}

// Activa el spinner del botón al enviar y lo deshabilita (evita doble envío)
function activarSpinnerBoton(boton) {
    if (!boton) return;
    boton.disabled = true;
    boton.innerHTML =
        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
        'Procesando...';
}
