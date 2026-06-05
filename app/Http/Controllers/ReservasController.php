<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;            
use Illuminate\Support\Facades\Auth;    
use App\Models\Reserva;                  
use App\Models\Habitacion;               
use App\Models\User;                     


class ReservasController extends Controller
{
    // ==================================================================
    //  ============= ZONA ADMINISTRACIÓN (CRUD) =============
    // ==================================================================

    public function mostrar()
    {
        // Reserva::all() ejecuta un SELECT * FROM reservas
        // y devuelve una Collection de objetos Reserva.
        $reservas = Reserva::all();

        // Pasamos la colección a la vista 'reservas' (resources/views/reservas.blade.php).
        return view('reservas', ['reservas' => $reservas]);
    }


    public function mostrarFormIns()
    {
        // Solo habitaciones disponibles (no enseñamos las ocupadas)
        $habitaciones = Habitacion::where('estado', 'disponible')->get();

        // Todos los usuarios para el autocompletado AJAX del cliente
        $users        = User::all();

        return view('formularioReserva', [
            'habitaciones' => $habitaciones,
            'users'        => $users
        ]);
    }


    public function insertar(Request $request)
    {
        //Validar los datos del formulario.
        // - 'after_or_equal:today' = la entrada NUNCA puede ser anterior a hoy.
        // - 'after:fechaEntrada' = validación cruzada: la salida debe ser
        //   POSTERIOR a la entrada (no puedes salir el mismo día o antes).
        $request->validate([
            'fechaEntrada' => ['required', 'date', 'after_or_equal:today'],
            'fechaSalida'  => ['required', 'date', 'after:fechaEntrada'],
            'idUser'       => ['required', 'integer'],
            'idHabitacion' => ['required', 'integer'],
        ], [
            'fechaEntrada.after_or_equal' => 'La fecha de entrada no puede ser anterior a hoy.',
            'fechaSalida.after'           => 'La fecha de salida debe ser posterior a la de entrada.',
        ]);

        $titular = User::find($request->idUser);
        if (!$titular || $titular->idRol != 3) {
            return back()->withInput()->withErrors([
                'idUser' => 'El titular de la reserva debe ser un usuario con rol cliente.',
            ]);
        }

        //Calcular el TOTAL de la reserva.
        // - Cargamos la habitación elegida para conocer su precio.
        // - Carbon es una librería de fechas. diffInDays() calcula días entre fechas.
        // - total = días × precio por noche.
        $habitacion = Habitacion::where('id', $request->idHabitacion)->first();
        $dias       = \Carbon\Carbon::parse($request->fechaEntrada)->diffInDays($request->fechaSalida);
        $total      = $dias * $habitacion->precio;

        // PASO 3: Crear la reserva.
        // Instanciamos el modelo y asignamos campos uno a uno.
        $reserva               = new Reserva();
        $reserva->fechaEntrada = $request->fechaEntrada;
        $reserva->fechaSalida  = $request->fechaSalida;
        $reserva->estado       = 'pendiente';                     // Todas empiezan así
        $reserva->total        = $total;
        $reserva->idUser       = $request->idUser;
        $reserva->idHabitacion = $request->idHabitacion;

        // save() ejecuta INSERT INTO reservas (...) VALUES (...)
        $reserva->save();

        // Redirigir al listado de reservas
        return redirect('/admin/reservas');
    }

    public function mostrarFormEd($id)
    {
        $reserva      = Reserva::where('id', $id)->first();
        $habitaciones = Habitacion::all();
        $users        = User::all();

        return view('formularioReserva', [
            'reserva'      => $reserva,
            'habitaciones' => $habitaciones,
            'users'        => $users
        ]);
    }


    public function editar($id, Request $request)
    {
        $request->validate([
            'fechaEntrada' => ['required', 'date'],
            'fechaSalida'  => ['required', 'date', 'after:fechaEntrada'],
            'estado'       => ['required', 'string'],
            'idUser'       => ['required', 'integer'],
            'idHabitacion' => ['required', 'integer'],
        ]);

        // Regla de negocio: el nuevo titular tiene que ser cliente.
        // Evita que al editar se reasigne la reserva a un admin/recepcionista.
        $titular = User::find($request->idUser);
        if (!$titular || $titular->idRol != 3) {
            return back()->withInput()->withErrors([
                'idUser' => 'El titular de la reserva debe ser un usuario con rol cliente.',
            ]);
        }

        // Regla de negocio: una reserva NO puede marcarse como "completada"
        // si la fecha de salida todavía no ha pasado. Lógico: el cliente
        // sigue alojado (o aún no ha llegado), no puede estar "completada".
        if ($request->estado === 'completada'
            && \Carbon\Carbon::parse($request->fechaSalida)->isFuture()) {
            return back()->withInput()->withErrors([
                'estado' => 'No se puede marcar como completada una reserva cuya fecha de salida aún no ha pasado.',
            ]);
        }

        // Recalcular el total por si cambiaron las fechas o la habitación
        $habitacion = Habitacion::where('id', $request->idHabitacion)->first();
        $dias       = \Carbon\Carbon::parse($request->fechaEntrada)->diffInDays($request->fechaSalida);
        $total      = $dias * $habitacion->precio;

        // Buscamos la reserva ya existente
        $reserva               = Reserva::where('id', $id)->first();
        $reserva->fechaEntrada = $request->fechaEntrada;
        $reserva->fechaSalida  = $request->fechaSalida;
        $reserva->estado       = $request->estado;
        $reserva->total        = $total;
        $reserva->idUser       = $request->idUser;
        $reserva->idHabitacion = $request->idHabitacion;

        // save() ejecuta UPDATE reservas SET ... WHERE id = $id
        $reserva->save();

        return redirect('/admin/reservas');
    }


    public function eliminar($id)
    {
        $reserva = Reserva::where('id', $id)->first();
        $reserva->delete();  // DELETE FROM reservas WHERE id = $id
        return redirect('/admin/reservas');
    }

    public function listar()
    {
        $reservas = Reserva::with(['user', 'habitacion'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json([
            'status'   => 200,
            'reservas' => $reservas
        ]);
    }


    public function buscarUsuarios(Request $request)
    {
        // Cogemos el parámetro ?q=... y le quitamos espacios al borde.
        // Si no llega 'q', usamos cadena vacía por defecto.
        $q = trim($request->input('q', ''));

        // No buscamos hasta tener al menos 2 letras (evita ruido y carga al servidor)
        if (strlen($q) < 2) {
            return response()->json([]);  // devolvemos array vacío en JSON
        }

        // Solo usuarios con rol CLIENTE (idRol = 3).
        // Los admins y recepcionistas NO pueden ser titulares de reservas:
        // solo pueden crearlas a nombre de un cliente real.
        // Por eso filtro el autocompletado para que únicamente devuelva
        // gente con rol cliente.
        //
        // SELECT id, nombre, apellidos, email
        // FROM users
        // WHERE idRol = 3
        //   AND (nombre LIKE '%texto%' OR apellidos LIKE '%texto%' OR email LIKE '%texto%')
        // LIMIT 10
        $users = User::where('idRol', 3)
                    ->where(function ($query) use ($q) {
                        $query->where('nombre',    'like', "%{$q}%")
                              ->orWhere('apellidos', 'like', "%{$q}%")
                              ->orWhere('email',     'like', "%{$q}%");
                    })
                    ->limit(10)
                    ->get(['id', 'nombre', 'apellidos', 'email']);

        //convierte la colección a JSON.
        return response()->json($users);
    }


    // ==================================================================
    //  ============= ZONA CLIENTE (pública) =============
    // ==================================================================

    public function catalogoCliente()
    {
        $habitaciones = Habitacion::where('estado', 'disponible')
                            ->orderBy('precio', 'asc')
                            ->get()
                            ->groupBy('tipo')
                            ->map(function ($grupo) { return $grupo->first(); })
                            ->values();

        return view('habitacionesCliente', ['habitaciones' => $habitaciones]);
    }

    public function detalleHabitacion($id)
    {
        $habitacion = Habitacion::find($id);

        // Si no se encontró, redirigir al catálogo con mensaje de error
        if (!$habitacion) {
            return redirect()->route('habitaciones.catalogo')
                             ->with('error', 'Esa habitación no existe.');
        }

        return view('detalleHabitacion', ['habitacion' => $habitacion]);
    }

    public function formularioReservarCliente($id)
    {
        
        if (Auth::user()->idRol != 3) {
            return redirect()->route('habitaciones.catalogo')
                ->with('error', 'Solo los clientes pueden hacer reservas desde aquí. '
                              . 'Como personal del hotel, crea la reserva desde el panel de administración.');
        }

        $habitacion = Habitacion::find($id);

        // Comprobamos que existe y está disponible
        if (!$habitacion || $habitacion->estado != 'disponible') {
            return redirect()->route('habitaciones.catalogo')
                             ->with('error', 'Esa habitación no está disponible.');
        }

        // Cargamos los servicios para enseñarlos como checkboxes opcionales
        $servicios = \App\Models\Servicio::orderBy('nombre')->get();

        return view('reservarCliente', [
            'habitacion' => $habitacion,
            'servicios'  => $servicios
        ]);
    }

    public function reservarComoCliente($id, Request $request)
    {
        //SOLO clientes pueden reservar desde aquí.
        if (Auth::user()->idRol != 3) {
            return redirect()->route('habitaciones.catalogo')
                ->with('error', 'Solo los clientes pueden hacer reservas a su nombre.');
        }

        $request->validate([
            'fechaEntrada' => ['required', 'date', 'after_or_equal:today'],
            'fechaSalida'  => ['required', 'date', 'after:fechaEntrada'],
            'servicios'    => ['nullable', 'array'],
            'servicios.*'  => ['integer', 'exists:servicios,id'],
        ], [
            'fechaEntrada.required'       => 'La fecha de entrada es obligatoria.',
            'fechaEntrada.date'           => 'La fecha de entrada no es válida.',
            'fechaEntrada.after_or_equal' => 'La fecha de entrada no puede ser anterior a hoy.',
            'fechaSalida.required'        => 'La fecha de salida es obligatoria.',
            'fechaSalida.date'            => 'La fecha de salida no es válida.',
            'fechaSalida.after'           => 'La fecha de salida debe ser posterior a la de entrada.',
            'servicios.array'             => 'El formato de los servicios no es válido.',
            'servicios.*.exists'          => 'Uno de los servicios seleccionados no existe.',
        ]);

        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            return redirect()->route('habitaciones.catalogo')
                             ->with('error', 'Habitación no encontrada.');
        }

        // 1) Total de la habitación: noches × precio
        $dias  = \Carbon\Carbon::parse($request->fechaEntrada)
                    ->diffInDays($request->fechaSalida);
        $total = $dias * $habitacion->precio;

        // 2) Sumamos el precio de los servicios elegidos (si hay)
        $idsServicios = $request->input('servicios', []);
        if (!empty($idsServicios)) {
            $totalServicios = \App\Models\Servicio::whereIn('id', $idsServicios)->sum('precio');
            $total += $totalServicios;
        }

        // 3) Crear la reserva
        $reserva               = new Reserva();
        $reserva->fechaEntrada = $request->fechaEntrada;
        $reserva->fechaSalida  = $request->fechaSalida;
        $reserva->estado       = 'pendiente';
        $reserva->total        = $total;
        $reserva->idUser       = Auth::id();
        $reserva->idHabitacion = $habitacion->id;
        $reserva->save();

        // 4) Vincular los servicios a la reserva (tabla pivote reserva_servicio).
        //    attach() añade los pares en la tabla intermedia.
        if (!empty($idsServicios)) {
            $reserva->servicios()->attach($idsServicios);
        }

        return redirect()->route('miCuenta')
                         ->with('mensaje', '¡Reserva creada con éxito! Te contactaremos pronto.');
    }


    /**
     *  El cliente cancela su PROPIA reserva.
     */
    public function cancelarComoCliente($id)
    {
        $reserva = Reserva::find($id);

        // CONTROL 1: La reserva existe Y es del usuario logueado.
        if (!$reserva || $reserva->idUser != Auth::id()) {
            return redirect()->route('miCuenta')
                             ->with('error', 'No puedes cancelar esta reserva.');
        }

        // CONTROL 2: No se puede cancelar una reserva ya cerrada.
        // in_array() comprueba si un valor está en un array.
        if (in_array($reserva->estado, ['cancelada', 'completada'])) {
            return redirect()->route('miCuenta')
                             ->with('error', 'Esta reserva ya no se puede cancelar.');
        }

        // Marcar como cancelada (no la borramos, solo cambiamos el estado)
        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect()->route('miCuenta')
                         ->with('mensaje', 'Reserva cancelada correctamente.');
    }
}
