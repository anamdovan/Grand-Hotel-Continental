$(document).ready(function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl = document.getElementById('tablaUsuarios');

    var urlIdioma  = tablaEl.dataset.idioma;        // ruta al JSON de idioma
    var urlAjax    = tablaEl.dataset.api;           // endpoint /api/usuarios
    var urlEditar  = tablaEl.dataset.editar;        // base /admin/usuarios/editar
    var urlBorrar  = tablaEl.dataset.borrar;        // base /admin/usuarios/eliminar
    var miId       = tablaEl.dataset.usuarioId;     // id del usuario logueado (puede estar vacío)

    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ----- 2) Inicialización de DataTables -----
    new DataTable('#tablaUsuarios', {

        language: { url: urlIdioma },

        ajax: {
            url:      urlAjax,
            type:     'GET',
            dataType: 'json',
            headers:  { 'X-CSRF-TOKEN': csrf },
            dataSrc: function (response) {
                if (response.status === 200) return response.usuarios;
                return [];
            }
        },

        columns: [
            { data: 'id' },
            { data: 'nombre',    render: function (d) { return d || '—'; } },
            { data: 'apellidos', render: function (d) { return d || '—'; } },
            { data: 'email' },
            { data: 'telefono',  render: function (d) { return d || '—'; } },
            {
                data: 'rol',
                render: function (d) {
                    if (d === 'admin')          return '<span class="badge bg-danger">Administrador</span>';
                    if (d === 'recepcionista')  return '<span class="badge bg-warning text-dark">Recepcionista</span>';
                    if (d === 'cliente')        return '<span class="badge bg-success">Cliente</span>';
                    return '<span class="badge bg-secondary">' + (d || 'Sin rol') + '</span>';
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

                    // Botón Eliminar: bloqueado si es el propio usuario logueado
                    if (miId && row.id == miId) {
                        btns += '<span class="btn btn-sm btn-outline-secondary disabled btn-disabled-visual" ' +
                                '       title="No puedes eliminar tu propia cuenta">' +
                                '   <i class="bi bi-trash"></i></span>';
                    } else {
                        var nombre = row.nombre || row.email;
                        btns += '<a href="' + urlBorrar + '/' + row.id + '" ' +
                                '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                                '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar al usuario ' + nombre + '?\');" ' +
                                '   title="Eliminar">' +
                                '   <i class="bi bi-trash"></i></a>';
                    }

                    return btns;
                }
            }
        ]
    });

});
