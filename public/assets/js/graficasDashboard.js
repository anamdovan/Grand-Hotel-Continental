/* =====================================================================
   graficasDashboard.js
   ---------------------------------------------------------------------
   Construye las 3 gráficas del dashboard usando Chart.js.
   Lee los datos JSON desde el atributo data-datos de cada <canvas>.
   Así no hay PHP/Blade mezclado con JavaScript.
 ===================================================================== */
document.addEventListener('DOMContentLoaded', function () {

    // ----- 1) Lectura de los 3 datasets desde los canvas -----
    var canvas1 = document.getElementById('dashboard');
    var canvas2 = document.getElementById('topHabitaciones');
    var canvas3 = document.getElementById('mejorValoradas');

    var datos       = JSON.parse(canvas1.dataset.datos);
    var topHabits   = JSON.parse(canvas2.dataset.datos);
    var mejorValora = JSON.parse(canvas3.dataset.datos);


    // ============================================================
    //  GRÁFICA 1 — Reservas por mes
    // ============================================================
    new Chart(canvas1, {
        type: 'bar',
        data: {
            labels: datos.map(row => row.mes),
            datasets: [{
                label: 'Número de reservas / mes',
                data: datos.map(row => row.total),
                backgroundColor: 'rgba(201, 169, 97, 0.6)',   // dorado claro translúcido
                borderColor:     'rgba(168, 137, 63, 1)',     // dorado oscuro
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });


    // ============================================================
    //  GRÁFICA 2 — Habitaciones más reservadas (con JOIN)
    // ============================================================
    new Chart(canvas2, {
        type: 'bar',
        data: {
            // Etiqueta: "Suite (nº 401)"
            labels: topHabits.map(row => row.tipo + ' (nº ' + row.numero + ')'),
            datasets: [{
                label: 'Número total de reservas',
                data: topHabits.map(row => row.total_reservas),
                backgroundColor: 'rgba(230, 211, 163, 0.7)',
                borderColor:     'rgba(168, 137, 63, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',          // barras horizontales
            scales: {
                x: { beginAtZero: true }
            }
        }
    });


    // ============================================================
    //  GRÁFICA 3 — Habitaciones MEJOR VALORADAS (JOIN + AVG)
    // ============================================================
    new Chart(canvas3, {
        type: 'bar',
        data: {
            labels: mejorValora.map(row => row.tipo + ' (nº ' + row.numero + ')'),
            datasets: [{
                label: 'Nota media (de 5)',
                data: mejorValora.map(row => row.nota_media),
                backgroundColor: 'rgba(201, 169, 97, 0.6)',
                borderColor:     'rgba(168, 137, 63, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,         // máximo 5 estrellas
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

});
