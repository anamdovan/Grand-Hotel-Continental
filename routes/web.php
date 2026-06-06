<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\OpinionesController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\DashboardController;
use App\Models\Reserva;        // Para el dashboard (reservas por mes)
use App\Models\Habitacion;     // Para el dashboard (habitaciones más reservadas)
use App\Models\Opinion;        // Para el dashboard (habitaciones mejor valoradas)


// =====================================================================
//  PÁGINA PRINCIPAL (pública)
// =====================================================================
Route::get('/', function () {
    return view('inicio', [
        'opinionesDestacadas' => Opinion::getDestacadas(),
    ]);
})->name('inicio');

// Página de "Sin permisos" → la usa el middleware Role
Route::get('/noPermitido', function () {
    return view('noPermitido');
})->name('noPermitido');

// =====================================================================
//  CONTACTO (público, no requiere login)
// =====================================================================
Route::get('/contacto',  [MensajesController::class, 'mostrarFormulario'])->name('contacto');
Route::post('/contacto', [MensajesController::class, 'enviar'])->name('contacto.enviar');


// =====================================================================
//  SESIÓN  ─  Login, registro, logout
// =====================================================================
Route::get('/login',     [SesionController::class, 'mostrar'])->name('login');
Route::post('/login',    [SesionController::class, 'iniciarSesion']);
Route::get('/registro',  [SesionController::class, 'mostrarRegistro'])->name('formularioRegistro');
Route::post('/registro', [SesionController::class, 'registro'])->name('registro');
Route::get('/logout',    [SesionController::class, 'cerrarSesion'])->name('logout');


// =====================================================================
//  ZONA CLIENTE  ─  Reservas desde la web pública
// =====================================================================
// Catálogo público (cualquiera puede verlo, esté logueado o no)
Route::get('/habitaciones',      [ReservasController::class, 'catalogoCliente'])->name('habitaciones.catalogo');
Route::get('/habitaciones/{id}', [ReservasController::class, 'detalleHabitacion'])->name('habitaciones.detalle');

// Las siguientes rutas requieren login (middleware 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/miCuenta', function () {
        return view('miCuenta');
    })->name('miCuenta');

    Route::get('/reservar/{id}',  [ReservasController::class, 'formularioReservarCliente'])->name('reservar.form');
    Route::post('/reservar/{id}', [ReservasController::class, 'reservarComoCliente'])->name('reservar.guardar');
    Route::get('/miCuenta/cancelar/{id}', [ReservasController::class, 'cancelarComoCliente'])->name('reservar.cancelar');

    // Opiniones del cliente (sobre sus propias reservas)
    Route::get('/miCuenta/opinar/{idReserva}',  [OpinionesController::class, 'mostrarFormOpinar'])->name('opinar.form');
    Route::post('/miCuenta/opinar/{idReserva}', [OpinionesController::class, 'guardarOpinion'])->name('opinar.guardar');
});


// =====================================================================
//  ZONA ADMINISTRACIÓN  ─  Solo admin y recepcionista (middleware 'role')
//  Todas las rutas dentro del group() llevan el middleware aplicado.
// =====================================================================
Route::middleware('role:admin,recepcionista')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'mostrar'])->name('admin.dashboard');

    // ----- HABITACIONES (recepcionista: ver, crear, editar — NO eliminar) -----
    Route::get('/habitaciones',                [HabitacionesController::class, 'mostrar']);
    Route::get('/habitaciones/crear',          [HabitacionesController::class, 'mostrarFormIns']);
    Route::post('/habitaciones/crear',         [HabitacionesController::class, 'insertar']);
    Route::get('/habitaciones/editar/{id}',    [HabitacionesController::class, 'mostrarFormEd']);
    Route::post('/habitaciones/editar/{id}',   [HabitacionesController::class, 'editar']);

    // ----- RESERVAS (CRUD completo para ambos) -----
    Route::get('/reservas',                    [ReservasController::class, 'mostrar']);
    Route::get('/reservas/crear',              [ReservasController::class, 'mostrarFormIns']);
    Route::post('/reservas/crear',             [ReservasController::class, 'insertar']);
    Route::get('/reservas/editar/{id}',        [ReservasController::class, 'mostrarFormEd']);
    Route::post('/reservas/editar/{id}',       [ReservasController::class, 'editar']);
    Route::get('/reservas/eliminar/{id}',      [ReservasController::class, 'eliminar']);

    // ----- PAGOS (CRUD para ambos) -----
    Route::get('/pagos',                       [PagosController::class, 'mostrar']);
    Route::get('/pagos/crear',                 [PagosController::class, 'mostrarFormIns']);
    Route::post('/pagos/crear',                [PagosController::class, 'insertar']);
    Route::get('/pagos/editar/{id}',           [PagosController::class, 'mostrarFormEd']);
    Route::post('/pagos/editar/{id}',          [PagosController::class, 'editar']);
    Route::get('/pagos/eliminar/{id}',         [PagosController::class, 'eliminar']);

    // ----- OPINIONES (recepcionista: SOLO ver) -----
    Route::get('/opiniones',                   [OpinionesController::class, 'mostrarAdmin'])->name('admin.opiniones');

    // ----- MENSAJES (recepcionista puede responder pero NO eliminar) -----
    Route::get('/mensajes',                    [MensajesController::class, 'mostrarAdmin'])->name('admin.mensajes');
    Route::get('/mensajes/responder/{id}',     [MensajesController::class, 'mostrarResponder'])->name('admin.mensajes.responder');
    Route::post('/mensajes/responder/{id}',    [MensajesController::class, 'guardarRespuesta'])->name('admin.mensajes.guardar');
});


// =====================================================================
//  ZONA ADMINISTRACIÓN ESTRICTA  ─  SOLO admin 
//  - Servicios (CRUD entero)
//  - Eliminar habitaciones
//  - Eliminar opiniones
//  - Eliminar mensajes
// =====================================================================
Route::middleware('role:admin')->prefix('admin')->group(function () {

    // Eliminar habitaciones (solo admin)
    Route::get('/habitaciones/eliminar/{id}',  [HabitacionesController::class, 'eliminar']);

    // Servicios (CRUD entero, solo admin)
    Route::get('/servicios',                   [ServiciosController::class, 'mostrar']);
    Route::get('/servicios/crear',             [ServiciosController::class, 'mostrarFormIns']);
    Route::post('/servicios/crear',            [ServiciosController::class, 'insertar']);
    Route::get('/servicios/editar/{id}',       [ServiciosController::class, 'mostrarFormEd']);
    Route::post('/servicios/editar/{id}',      [ServiciosController::class, 'editar']);
    Route::get('/servicios/eliminar/{id}',     [ServiciosController::class, 'eliminar']);

    // Eliminar opiniones (solo admin)
    Route::get('/opiniones/eliminar/{id}',     [OpinionesController::class, 'eliminarAdmin'])->name('admin.opiniones.eliminar');

    // Eliminar mensajes (solo admin)
    Route::get('/mensajes/eliminar/{id}',      [MensajesController::class, 'eliminar'])->name('admin.mensajes.eliminar');

    // ----- USUARIOS (CRUD completo, solo admin) -----
    Route::get('/usuarios',                    [\App\Http\Controllers\UsuariosController::class, 'mostrar'])->name('admin.usuarios');
    Route::get('/usuarios/crear',              [\App\Http\Controllers\UsuariosController::class, 'mostrarFormIns']);
    Route::post('/usuarios/crear',             [\App\Http\Controllers\UsuariosController::class, 'insertar']);
    Route::get('/usuarios/editar/{id}',        [\App\Http\Controllers\UsuariosController::class, 'mostrarFormEd']);
    Route::post('/usuarios/editar/{id}',       [\App\Http\Controllers\UsuariosController::class, 'editar']);
    Route::get('/usuarios/eliminar/{id}',      [\App\Http\Controllers\UsuariosController::class, 'eliminar']);
});


// =====================================================================
//  API (devuelve JSON)
// =====================================================================
Route::prefix('api')->group(function () {
    Route::get('/habitaciones',     [App\Http\Controllers\HabitacionesController::class, 'listar']);
    Route::get('/servicios',        [App\Http\Controllers\ServiciosController::class, 'listar']);
    Route::get('/reservas',         [App\Http\Controllers\ReservasController::class,    'listar']);
    Route::get('/opiniones',        [App\Http\Controllers\OpinionesController::class,   'listar']);
    Route::get('/mensajes',         [App\Http\Controllers\MensajesController::class,    'listar']);
    Route::get('/usuarios',         [App\Http\Controllers\UsuariosController::class,    'listar']);
});
