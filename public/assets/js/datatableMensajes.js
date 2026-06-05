/* =====================================================================
   datatableMensajes.js
   ---------------------------------------------------------------------
   Inicializa la tabla DataTables del listado de mensajes (admin).
   Lee las URLs y el rol del usuario desde data-attributes
   puestos en la etiqueta <table id="tablaMensajes"> de la vista Blade.
 ===================================================================== */
$(document).ready(function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl     = document.getElementById('tablaMensajes');
    var urlIdioma   = tablaEl.dataset.idioma;
    var urlAjax     = tablaEl.dataset.api;
    var urlResponder = tablaEl.dataset.responder;
    var urlBorrar   = tablaEl.dataset.borrar;
    var esAdmin     = tablaEl.dataset.esAdmin === '1';

    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Auxiliar: formatea fecha 'YYYY-MM-DD HH:MM:SS' a 'dd/mm/aaaa HH:MM'
    function formatFechaHora(s) {
        if (!s) return '—';
        var d = new Date(s);
        return ('0' + d.getDate()).slice(-2) + '/' +
               ('0' + (d.getMonth() + 1)).slice(-2) + '/' +
               d.getFullYear() + ' ' +
               ('0' + d.getHours()).slice(-2) + ':' +
               ('0' + d.getMinutes()).slice(-2);
    }

    // ----- 2) Inicialización de DataTables -----
    new DataTable('#tablaMensajes', {

        language: { url: urlIdioma },

        ajax: {
            url:      urlAjax,
            type:     'GET',
            dataType: 'json',
            headers:  { 'X-CSRF-TOKEN': csrf },
            dataSrc:  function (response) {
                if (response.status === 200) return response.mensajes;
                return [];
            }
        },

        // Ordenar por fecha más reciente arriba (columna 5 = Fecha)
        order: [[5, 'desc']],

        columns: [
            {
                // ESTADO: Respondido / Pendiente
                data: null,
                render: function (data, type, row) {
                    if (row.respuesta) {
                        return '<span class="badge bg-success"><i class="bi bi-reply-fill"></i> Respondido</span>';
                    }
                    return '<span class="badge bg-warning text-dark"><i class="bi bi-envelope"></i> Pendiente</span>';
                }
            },
            { data: 'nombre' },
            {
                data: null,
                render: function (data, type, row) {
                    var html = '<a href="mailto:' + row.email + '">' + row.email + '</a>';
                    if (row.telefono) {
                        html += '<br><small class="text-muted">' + row.telefono + '</small>';
                    }
                    return html;
                }
            },
            { data: 'asunto' },
            {
                data: 'mensaje',
                render: function (d) {
                    if (!d) return '—';
                    return '<small>' + (d.length > 100 ? d.substring(0, 100) + '...' : d) + '</small>';
                }
            },
            { data: 'created_at', render: formatFechaHora },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {

                    // Botón Responder / Ver respuesta
                    var icono  = row.respuesta ? 'eye' : 'reply';
                    var titulo = row.respuesta ? 'Ver respuesta' : 'Responder';

                    var btns = '<a href="' + urlResponder + '/' + row.id + '" ' +
                               '   class="btn btn-sm btn-outline-primary" ' +
                               '   title="' + titulo + '">' +
                               '   <i class="bi bi-' + icono + '"></i></a> ';

                    if (esAdmin) {
                        // ADMIN → botón eliminar activo
                        btns += '<a href="' + urlBorrar + '/' + row.id + '" ' +
                                '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                                '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar este mensaje?\');" ' +
                                '   title="Eliminar">' +
                                '   <i class="bi bi-trash"></i></a>';
                    } else {
                        // RECEPCIONISTA → botón eliminar bloqueado
                        btns += '<span class="btn btn-sm btn-outline-secondary disabled btn-disabled-visual" ' +
                                '       title="Solo el administrador puede eliminar mensajes">' +
                                '   <i class="bi bi-trash"></i></span>';
                    }

                    return btns;
                }
            }
        ]
    });

});
