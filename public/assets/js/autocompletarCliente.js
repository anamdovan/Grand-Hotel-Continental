/* =====================================================================
   Autocompletado AJAX del campo "Cliente" del formulario de reservas
   (admin)
 ===================================================================== */
document.addEventListener('DOMContentLoaded', function () {

    var buscador  = document.getElementById('buscadorCliente');
    var idUser    = document.getElementById('idUser');
    var resultados = document.getElementById('resultadosCliente');
    var urlBuscar = buscador.dataset.url;     // endpoint AJAX
    var timeoutId = null;

    // Al escribir en el campo de búsqueda
    buscador.addEventListener('input', function () {
        var query = buscador.value.trim();

        // Si cambia el texto, invalida el id seleccionado
        idUser.value = '';

        // DEBOUNCE: esperamos 300ms tras la última pulsación antes de buscar
        clearTimeout(timeoutId);

        if (query.length < 2) {
            resultados.classList.remove('activo');
            resultados.innerHTML = '';
            return;
        }

        timeoutId = setTimeout(function () {
            buscarUsuarios(query);
        }, 300);
    });

    // Llamada AJAX al endpoint
    function buscarUsuarios(query) {
        fetch(urlBuscar + '?q=' + encodeURIComponent(query), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (resp) { return resp.json(); })
        .then(function (data) { pintarResultados(data); })
        .catch(function () {
            resultados.innerHTML = '<div class="autocompletado-vacio">Error al buscar</div>';
        });
    }

    // Pinta los usuarios devueltos por el servidor
    function pintarResultados(usuarios) {

        resultados.classList.add('activo');

        if (!usuarios || usuarios.length === 0) {
            resultados.innerHTML = '<div class="autocompletado-vacio"><i class="bi bi-emoji-frown"></i> Sin resultados</div>';
            return;
        }

        var html = '';
        usuarios.forEach(function (u) {
            var apellidos = u.apellidos || '';
            var texto     = (u.nombre + ' ' + apellidos + ' (' + u.email + ')').replace(/"/g, '&quot;');
            html += '<div class="autocompletado-item" data-id="' + u.id + '" data-texto="' + texto + '">' +
                        '<strong>' + u.nombre + ' ' + apellidos + '</strong>' +
                        '<small>' + u.email + '</small>' +
                    '</div>';
        });
        resultados.innerHTML = html;

        // Al hacer clic en un resultado, lo seleccionamos
        resultados.querySelectorAll('.autocompletado-item').forEach(function (item) {
            item.addEventListener('click', function () {
                idUser.value   = item.dataset.id;     // id que se enviará al servidor
                buscador.value = item.dataset.texto;  // texto que ve el usuario
                resultados.classList.remove('activo');
            });
        });
    }

});
