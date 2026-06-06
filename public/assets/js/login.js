/* ===================================================================
   FUNCIÓN PARA VALIDAR EL EMAIL
 ===================================================================== */

// Lista de extensiones de dominio (TLD) válidas
var TLDS_VALIDOS = [
    'com', 'org', 'net', 'edu', 'gov', 'info',
    'es', 'eu', 'uk', 'fr', 'de', 'it', 'pt', 'nl', 'be', 'at', 'ch', 'se', 'no', 'fi', 'dk', 'ie', 'ro'
];

// Comprueba que el email tiene formato válido y un TLD aceptado
function validarEmail(email) {
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(email)) return false;

    var tld = email.split('.').pop().toLowerCase();
    return TLDS_VALIDOS.indexOf(tld) !== -1;
}


/* =====================================================================
   VALIDACIÓN DEL FORMULARIO COMPLETO AL ENVIAR
 ===================================================================== */

function validarLogin(form) {
    var emailInput    = form.querySelector('input[name="email"]');
    var passwordInput = form.querySelector('input[name="password"]');
    var todoOk = true;

    // EMAIL: debe tener formato válido
    if (!validarEmail(emailInput.value.trim())) {
        mostrarError(emailInput, 'Introduce un email válido (ejemplo@correo.com).');
        todoOk = false;
    } else {
        mostrarOk(emailInput);
    }

    if (passwordInput.value.trim() === '') {
        mostrarError(passwordInput, 'La contraseña no puede estar vacía.');
        todoOk = false;
    } else {
        mostrarOk(passwordInput);
    }

    return todoOk;
}


/* =====================================================================
   Validación del email en tiempo real
 ===================================================================== */
// var emailInput = document.getElementById('email');
// if (emailInput) {
//     emailInput.addEventListener('input', function () {
//         if (emailInput.value.trim() === '') {
//             resetearInput(emailInput);
//         } else if (validarEmail(emailInput.value)) {
//             mostrarOk(emailInput);
//         } else {
//             mostrarError(emailInput, 'Introduce un email válido (ejemplo@correo.com).');
//         }
//     });
// }

//opción corta usando en el argumento la función validadora
validarCampoEnTiempoReal('email', validarEmail, 'Introduce un email válido.');


// Submit del formulario
document.getElementById('formLogin').addEventListener('submit', function (e) {
    if (!validarLogin(this)) {
        e.preventDefault();
    } else {
        activarSpinnerBoton(document.getElementById('btnSubmit'));
    }
});
