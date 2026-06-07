document.addEventListener('DOMContentLoaded', function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var formEl      = document.getElementById('formReservarCliente');
    var precioNoche = parseFloat(formEl.dataset.precio);

    // Formatea un número como euros: 12.50 → "12,50 €"
    function formatEuros(n) {
        return n.toFixed(2).replace('.', ',') + ' €';
    }

    // ----- 2) Calcular el resumen del precio en tiempo real -----
    function actualizarResumen() {
        var entrada  = document.getElementById('fechaEntrada').value;
        var salida   = document.getElementById('fechaSalida').value;
        var noches   = document.getElementById('resumen-noches');
        var subtotal = document.getElementById('resumen-subtotal');
        var extras   = document.getElementById('resumen-extras');
        var total    = document.getElementById('resumen-total');

        //Subtotal habitación (noches * precio)
        var subTotHabit = 0;
        if (entrada && salida) {
            // Fórmula de las noches
            var d1   = new Date(entrada); //convierte la fecha en obj
            var d2   = new Date(salida);
            // se restan las dos fechas y el resultado son MILISEGUDNOS
            //y para para pasar esos milisegundos a días hay que dividir
            //entre cuantos milisegundos tiene un día: 1000 * 60 * 60 * 24
            //y lo redondeo el resultado para que no salgan cosas raras
            //como 2,99 noches
            var diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));
            if (diff > 0) {
                noches.textContent   = diff;
                subTotHabit          = diff * precioNoche;
                subtotal.textContent = formatEuros(subTotHabit);
            } else {
                noches.textContent   = '—';
                subtotal.textContent = '— €';
            }
        } else {
            noches.textContent   = '—';
            subtotal.textContent = '— €';
        }

        //Sumar servicios marcados
        var totalExtras = 0;
        document.querySelectorAll('.servicio-check:checked').forEach(function (cb) {
            totalExtras += parseFloat(cb.dataset.precio);
        });
        extras.textContent = formatEuros(totalExtras);

        //Total
        if (subTotHabit > 0 || totalExtras > 0) {
            total.textContent = formatEuros(subTotHabit + totalExtras);
        } else {
            total.textContent = '— €';
        }
    }

    // ----- 3) Listeners para recalcular cuando cambia algo -----
    document.getElementById('fechaEntrada').addEventListener('change', actualizarResumen);
    document.getElementById('fechaSalida').addEventListener('change', actualizarResumen);
    document.querySelectorAll('.servicio-check').forEach(function (cb) {
        cb.addEventListener('change', actualizarResumen);
    });

    // ----- 4) Validación del formulario al enviar -----
    formEl.addEventListener('submit', function (e) {
        var entrada = document.getElementById('fechaEntrada');
        var salida  = document.getElementById('fechaSalida');
        var todoOk  = true;

        if (entrada.value === '') {
            mostrarError(entrada, 'Fecha obligatoria.');
            todoOk = false;
        } else {
            mostrarOk(entrada);
        }

        if (salida.value === '') {
            mostrarError(salida, 'Fecha obligatoria.');
            todoOk = false;
        } else {
            mostrarOk(salida);
        }

        if (entrada.value !== '' && salida.value !== '' && entrada.value >= salida.value) {
            mostrarError(salida, 'La fecha de salida debe ser posterior a la de entrada.');
            todoOk = false;
        }

        if (!todoOk) {
            e.preventDefault();
        } else {
            activarSpinnerBoton(document.getElementById('btnSubmit'));
        }
    });

});
