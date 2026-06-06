/* =====================================================================
   FUNCIONES DE VALIDACIÓN
 ===================================================================== */

// Lista de extensiones de dominio (TLD) válidas
var TLDS_VALIDOS = [
    'com', 'org', 'net', 'edu', 'gov', 'info',
    'es', 'eu', 'uk', 'fr', 'de', 'it', 'pt', 'nl', 'be', 'at', 'ch', 'se', 'no', 'fi', 'dk', 'ie', 'ro'
];

// Email: formato válido y TLD aceptado
function validarEmail(email) {
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(email)) return false;

    var tld = email.split('.').pop().toLowerCase();
    return TLDS_VALIDOS.indexOf(tld) !== -1;
}

// Contraseña: 8+ chars, con mayúscula, minúscula y número
function validarPassword(password) {
    if (password.length < 8)     return false;
    if (!/[A-Z]/.test(password)) return false;
    if (!/[a-z]/.test(password)) return false;
    if (!/[0-9]/.test(password)) return false;
    return true;
}

// Nombre/apellidos: solo letras (con tildes y ñ) y espacios, 3-20 caracteres
function validarNombre(nombre) {
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,20}$/;
    return regex.test(nombre);
}

// Comprueba que las dos contraseñas son idénticas
function validarPasswordCoincide(pass, rePass) {
    return pass === rePass;
}


/* =====================================================================
   Funicón génerica:  validar un campo mientras se escribe
 ===================================================================== */

function validarCampoEnTiempoReal(inputId, validador, mensajeError) {
    var input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('input', function () {
        if (input.value.trim() === '') {
            resetearInput(input);
            return;
        }
        if (validador(input.value)) {
            mostrarOk(input);
        } else {
            mostrarError(input, mensajeError);
        }
    });
    
    input.addEventListener('blur', function () {
        if (input.value.trim() === '') {
            mostrarError(input, 'Este campo es obligatorio.');
            }
        });    
    
}


/* =====================================================================
   VALIDACIÓN DEL FORMULARIO COMPLETO AL ENVIAR
 ===================================================================== */

function validarRegistro(form) {
    var nombreInput     = form.querySelector('input[name="nombre"]');
    var apellidosInput  = form.querySelector('input[name="apellidos"]');
    var emailInput      = form.querySelector('input[name="email"]');
    var passwordInput   = form.querySelector('input[name="password"]');
    var rePasswordInput = form.querySelector('input[name="rePassword"]');

    var todoOk = true;

    // ====== NOMBRE ======
    if (nombreInput.value.trim() === '') {
        mostrarError(nombreInput, 'El nombre es obligatorio.');
        todoOk = false;
    } else if (!validarNombre(nombreInput.value.trim())) {
        mostrarError(nombreInput, 'El nombre debe contener solo letras (3-20 caracteres).');
        todoOk = false;
    } else {
        mostrarOk(nombreInput);
    }

    // ====== APELLIDOS ======
    if (apellidosInput.value.trim() === '') {
        mostrarError(apellidosInput, 'Los apellidos son obligatorios.');
        todoOk = false;
    } else if (!validarNombre(apellidosInput.value.trim())) {
        mostrarError(apellidosInput, 'Los apellidos deben contener solo letras (3-20 caracteres).');
        todoOk = false;
    } else {
        mostrarOk(apellidosInput);
    }

    // ====== EMAIL ======
    if (emailInput.value.trim() === '') {
        mostrarError(emailInput, 'El email es obligatorio.');
        todoOk = false;
    } else if (!validarEmail(emailInput.value.trim())) {
        mostrarError(emailInput, 'Introduce un email válido (ejemplo@correo.com).');
        todoOk = false;
    } else {
        mostrarOk(emailInput);
    }

    // ====== CONTRASEÑA ======
    if (passwordInput.value === '') {
        mostrarError(passwordInput, 'La contraseña es obligatoria.');
        todoOk = false;
    } else if (!validarPassword(passwordInput.value)) {
        mostrarError(passwordInput, 'Mínimo 8 caracteres, con mayúscula, minúscula y un número.');
        todoOk = false;
    } else {
        mostrarOk(passwordInput);
    }

    // ====== REPETIR CONTRASEÑA ======
    if (rePasswordInput.value === '') {
        mostrarError(rePasswordInput, 'Debes repetir la contraseña.');
        todoOk = false;
    } else if (!validarPasswordCoincide(passwordInput.value, rePasswordInput.value)) {
        mostrarError(rePasswordInput, 'Las contraseñas no coinciden.');
        todoOk = false;
    } else {
        mostrarOk(rePasswordInput);
    }

    return todoOk;
}


/* =====================================================================
   LISTENERS AL CARGAR LA PÁGINA
 ===================================================================== */

// Validación en tiempo real para cada campo
validarCampoEnTiempoReal('nombre',    validarNombre,   'Solo letras, entre 3 y 20 caracteres.');
validarCampoEnTiempoReal('apellidos', validarNombre,   'Solo letras, entre 3 y 20 caracteres.');
validarCampoEnTiempoReal('email',     validarEmail,    'Introduce un email válido.');
validarCampoEnTiempoReal('password',  validarPassword, 'Mínimo 8 caracteres, mayúscula, minúscula y número.');

// Coincidencia de contraseñas: a mano porque compara DOS campos
document.getElementById('rePassword').addEventListener('input', function () {
    var pass = document.getElementById('password').value;

    if (this.value === '') {
        resetearInput(this);
    } else if (validarPasswordCoincide(pass, this.value)) {
        mostrarOk(this);
    } else {
        mostrarError(this, 'Las contraseñas no coinciden.');
    }
});

// Submit del formulario
document.getElementById('formRegistro').addEventListener('submit', function (e) {
    if (!validarRegistro(this)) {
        e.preventDefault();
    } else {
        activarSpinnerBoton(document.getElementById('btnSubmit'));
    }
});
