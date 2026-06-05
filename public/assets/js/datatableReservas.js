/* =====================================================================
   datatableReservas.js
   ---------------------------------------------------------------------
   Inicializa la tabla DataTables del listado de reservas (admin).
   Lee las URLs desde data-attributes puestos en la etiqueta
 ===================================================================== */
$(document).ready(function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl   = document.getElementById('tablaReservas');
    var urlIdioma = tablaEl.dataset.idioma;
    var urlAjax   = tablaEl.dataset.api;
    var urlEditar = tablaEl.dataset.editar;
    var urlBorrar = tablaEl.dataset.borrar;

    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Función auxiliar: formatea 'YYYY-MM-DD HH:MM:SS' a 'dd/mm/aaaa'
    function formatFecha(s) {
        if (!s) return '—';
        var d = new Date(s);
        return ('0' + d.getDate()).slice(-2) + '/' +
               ('0' + (d.getMonth() + 1)).slice(-2) + '/' +
               d.getFullYear();
    }

    // ----- 2) Inicialización de DataTables -----
    new DataTable('#tablaReservas', {

        language: { url: urlIdioma },

        ajax: {
            url:      urlAjax,
            type:     'GET',
            dataType: 'json',
            headers:  { 'X-CSRF-TOKEN': csrf },
            dataSrc:  function (response) {
                if (response && response.status === 200 && Array.isArray(response.reservas)) {
                    return response.reservas;
                }
                return [];
            }
        },

        // Ordenar por id descendente (más recientes arriba)
        order: [[0, 'desc']],

        columns: [
            { data: 'id' },
            {
                data: null,
                render: function (data, type, row) {
                    var nombre = row.user ? row.user.nombre : '—';
                    var email  = row.user ? row.user.email  : '';
                    return '<strong>' + nombre + '</strong>' +
                           '<br><small class="text-muted">' + email + '</small>';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var num  = row.habitacion ? row.habitacion.numero : '—';
                    var tipo = row.habitacion ? row.habitacion.tipo   : '';
                    return '<strong>Nº ' + num + '</strong>' +
                           '<br><small class="text-muted">' + tipo + '</small>';
                }
            },
            { data: 'fechaEntrada', render: formatFecha },
            { data: 'fechaSalida',  render: formatFecha },
            {
                data: 'total',
                render: function (d) {
                    return '<strong>' + parseFloat(d || 0).toFixed(2).replace('.', ',') + ' €</strong>';
                }
            },
            {
                data: 'estado',
                render: function (d) {
                    switch (d) {
                        case 'pendiente':   return '<span class="badge bg-warning">Pendiente</span>';
                        case 'confirmada':  return '<span class="badge bg-info">Confirmada</span>';
                        case 'cancelada':   return '<span class="badge bg-danger">Cancelada</span>';
                        case 'completada':  return '<span class="badge bg-success">Completada</span>';
                        default:            return d;
                    }
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<a href="' + urlEditar + '/' + row.id + '" ' +
                           '   class="btn btn-sm btn-outline-primary" title="Editar">' +
                           '   <i class="bi bi-pencil"></i></a> ' +
                           '<a href="' + urlBorrar + '/' + row.id + '" ' +
                           '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                           '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar la reserva #' + row.id + '?\');" ' +
                           '   title="Eliminar">' +
                           '   <i class="bi bi-trash"></i></a>';
                }
            }
        ]
    });

});
