/* =====================================================================
   datatableOpiniones.js
   ---------------------------------------------------------------------
   Inicializa la tabla DataTables del listado de opiniones (admin).
   Lee las URLs y el rol del usuario desde data-attributes
   puestos en la etiqueta <table id="tablaOpiniones"> de la vista Blade.
 ===================================================================== */
$(document).ready(function () {

    // ----- 1) Lectura de configuración desde el HTML -----
    var tablaEl   = document.getElementById('tablaOpiniones');
    var urlIdioma = tablaEl.dataset.idioma;
    var urlAjax   = tablaEl.dataset.api;
    var urlBorrar = tablaEl.dataset.borrar;
    var esAdmin   = tablaEl.dataset.esAdmin === '1';

    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Auxiliar: pinta estrellas según la puntuación (1..5)
    function pintarEstrellas(n) {
        var html = '';
        for (var i = 1; i <= 5; i++) {
            if (i <= n) {
                html += '<i class="bi bi-star-fill text-estrella"></i>';
            } else {
                html += '<i class="bi bi-star text-estrella-vacia"></i>';
            }
        }
        return html;
    }

    // Auxiliar: formatea fecha 'YYYY-MM-DD HH:MM:SS' a 'dd/mm/aaaa'
    function formatFecha(s) {
        if (!s) return '—';
        var d = new Date(s);
        return ('0' + d.getDate()).slice(-2) + '/' +
               ('0' + (d.getMonth() + 1)).slice(-2) + '/' +
               d.getFullYear();
    }

    // ----- 2) Inicialización de DataTables -----
    new DataTable('#tablaOpiniones', {

        language: { url: urlIdioma },

        ajax: {
            url:      urlAjax,
            type:     'GET',
            dataType: 'json',
            headers:  { 'X-CSRF-TOKEN': csrf },
            dataSrc:  function (response) {
                if (response.status === 200) return response.opiniones;
                return [];
            }
        },

        // Por defecto ordenamos por id descendente (más nuevas arriba)
        order: [[0, 'desc']],

        columns: [
            { data: 'id' },
            {
                data: null,
                render: function (data, type, row) {
                    var nombre = row.user ? (row.user.nombre + ' ' + (row.user.apellidos || '')) : '—';
                    var email  = row.user ? row.user.email : '';
                    return '<strong>' + nombre + '</strong>' +
                           '<br><small class="text-muted">' + email + '</small>';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var tipo = row.habitacion ? row.habitacion.tipo   : '—';
                    var num  = row.habitacion ? row.habitacion.numero : '';
                    return '<strong>' + tipo + '</strong>' +
                           '<br><small class="text-muted">Nº ' + num + '</small>';
                }
            },
            {
                data: 'puntuacion',
                render: function (d) { return pintarEstrellas(d); }
            },
            {
                data: 'comentario',
                render: function (d) {
                    if (!d) return '—';
                    return '<small>' + (d.length > 80 ? d.substring(0, 80) + '...' : d) + '</small>';
                }
            },
            { data: 'created_at', render: formatFecha },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    if (esAdmin) {
                        // ADMIN → botón eliminar activo
                        return '<a href="' + urlBorrar + '/' + row.id + '" ' +
                               '   class="btn btn-sm btn-outline-primary btn-eliminar" ' +
                               '   onclick="return confirmarEliminacion(event, this.href, \'¿Eliminar esta opinión?\');" ' +
                               '   title="Eliminar">' +
                               '   <i class="bi bi-trash"></i></a>';
                    } else {
                        // RECEPCIONISTA → botón eliminar bloqueado
                        return '<span class="btn btn-sm btn-outline-secondary disabled btn-disabled-visual" ' +
                               '       title="Solo el administrador puede eliminar opiniones">' +
                               '   <i class="bi bi-trash"></i></span>';
                    }
                }
            }
        ]
    });

});
