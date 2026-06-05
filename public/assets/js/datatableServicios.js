document.addEventListener('DOMContentLoaded', function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl   = document.getElementById('tablaServicios');
    var urlAjax   = tablaEl.dataset.api;
    var urlEditar = tablaEl.dataset.editar;
    var urlBorrar = tablaEl.dataset.borrar;

    var tbody = document.getElementById('tabla-servicios');

    // ----- 2) Cargar los servicios al iniciar -----
    cargarServicios();

    function cargarServicios() {
        fetch(urlAjax, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (resp) { return resp.json(); })
        .then(function (data) { pintarServicios(data.servicios); })
        .catch(function () {
            tbody.innerHTML =
                '<tr><td colspan="5" class="text-center text-danger py-4">' +
                '<i class="bi bi-exclamation-triangle"></i> Error al cargar.' +
                '</td></tr>';
        });
    }

    function pintarServicios(servicios) {
        if (!servicios || servicios.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="5" class="text-center py-5 text-muted">' +
                '<i class="bi bi-stars icono-vacio"></i>' +
                '<p class="mt-2 mb-0">No hay servicios registrados.</p>' +
                '</td></tr>';
            return;
        }

        var html = '';
        servicios.forEach(function (s) {
            var desc = s.descripcion || '—';
            if (desc.length > 80) desc = desc.substring(0, 80) + '...';

            var precio = parseFloat(s.precio).toFixed(2).replace('.', ',') + ' €';

            html +=
                '<tr>' +
                    '<td><small class="text-muted">' + s.id + '</small></td>' +
                    '<td><strong>' + s.nombre + '</strong></td>' +
                    '<td class="text-muted">' + desc + '</td>' +
                    '<td><strong>' + precio + '</strong></td>' +
                    '<td class="text-center">' +
                        '<a href="' + urlEditar + '/' + s.id + '" ' +
                        '   class="btn btn-sm btn-outline-primary" title="Editar">' +
                        '   <i class="bi bi-pencil"></i>' +
                        '</a> ' +
                        '<a href="' + urlBorrar + '/' + s.id + '" ' +
                        '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                        '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar el servicio ' + s.nombre + '?\');" ' +
                        '   title="Eliminar">' +
                        '   <i class="bi bi-trash"></i>' +
                        '</a>' +
                    '</td>' +
                '</tr>';
        });
        tbody.innerHTML = html;
    }
});
