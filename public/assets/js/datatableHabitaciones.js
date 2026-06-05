/* =====================================================================
   datatableHabitaciones.js
   ---------------------------------------------------------------------
   Inicializa la tabla DataTables del listado de habitaciones (admin).
   Lee las URLs y el rol del usuario desde data-attributes
   puestos en la etiqueta <table id="tablaHabitaciones"> de la vista Blade.
 ===================================================================== */
$(document).ready(function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl   = document.getElementById('tablaHabitaciones');
    var urlIdioma = tablaEl.dataset.idioma;
    var urlAjax   = tablaEl.dataset.api;
    var urlEditar = tablaEl.dataset.editar;
    var urlBorrar = tablaEl.dataset.borrar;
    var esAdmin   = tablaEl.dataset.esAdmin === '1';   // "1" / "" → true / false

    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ----- 2) Inicialización de DataTables -----
    new DataTable('#tablaHabitaciones', {

        language: { url: urlIdioma },

        ajax: {
            url:      urlAjax,
            type:     'GET',
            dataType: 'json',
            headers:  { 'X-CSRF-TOKEN': csrf },
            dataSrc: function (response) {
                if (response.status === 200) return response.habitaciones;
                return [];
            }
        },

        columns: [
            { data: 'id' },
            { data: 'numero', render: function (d) { return '<strong>' + d + '</strong>'; } },
            { data: 'tipo' },
            {
                data: 'precio',
                render: function (d) {
                    return '<strong>' + parseFloat(d).toFixed(2).replace('.', ',') + ' €</strong>';
                }
            },
            {
                data: 'estado',
                render: function (d) {
                    if (d === 'disponible')  return '<span class="badge bg-success">Disponible</span>';
                    if (d === 'ocupada')     return '<span class="badge bg-danger">Ocupada</span>';
                    return '<span class="badge bg-warning">Mantenimiento</span>';
                }
            },
            {
                data: 'descripcion',
                render: function (d) {
                    if (!d) return '—';
                    return d.length > 60 ? d.substring(0, 60) + '...' : d;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {

                    // Botón Editar (siempre)
                    var btns = '<a href="' + urlEditar + '/' + row.id + '" ' +
                               '   class="btn btn-sm btn-outline-primary" title="Editar">' +
                               '   <i class="bi bi-pencil"></i></a> ';

                    if (esAdmin) {
                        // ADMIN → botón eliminar activo
                        btns += '<a href="' + urlBorrar + '/' + row.id + '" ' +
                                '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                                '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar la habitación Nº ' + row.numero + '?\');" ' +
                                '   title="Eliminar">' +
                                '   <i class="bi bi-trash"></i></a>';
                    } else {
                        // RECEPCIONISTA → botón eliminar bloqueado
                        btns += '<span class="btn btn-sm btn-outline-secondary disabled btn-disabled-visual" ' +
                                '       title="Solo el administrador puede eliminar habitaciones">' +
                                '   <i class="bi bi-trash"></i></span>';
                    }

                    return btns;
                }
            }
        ]
    });

});
