<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Opinion;
use App\Models\Reserva;


class OpinionesController extends Controller
{
    // ==================================================================
    //  ZONA CLIENTE
    // ==================================================================

    public function mostrarFormOpinar($idReserva)
    {
        $reserva = Reserva::find($idReserva);

        // Comprobar: existe, es del usuario logueado y está completada
        if (!$reserva || $reserva->idUser != Auth::id()) {
            return redirect()->route('miCuenta')
                ->with('error', 'No puedes opinar sobre esa reserva.');
        }
        if ($reserva->estado != 'completada') {
            return redirect()->route('miCuenta')
                ->with('error', 'Solo se puede opinar sobre reservas completadas.');
        }
        if ($reserva->opinion) {
            return redirect()->route('miCuenta')
                ->with('error', 'Ya has opinado sobre esta reserva.');
        }

        return view('opinarReserva', ['reserva' => $reserva]);
    }


    public function guardarOpinion($idReserva, Request $request)
    {
        // Validación servidor
        $request->validate([
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $reserva = Reserva::find($idReserva);
        if (!$reserva || $reserva->idUser != Auth::id() || $reserva->estado != 'completada') {
            return redirect()->route('miCuenta')
                ->with('error', 'No puedes opinar sobre esa reserva.');
        }

        // Crear la opinión
        $opinion               = new Opinion();
        $opinion->puntuacion   = $request->puntuacion;
        $opinion->comentario   = $request->comentario;
        $opinion->idUser       = Auth::id();
        $opinion->idHabitacion = $reserva->idHabitacion;
        $opinion->idReserva    = $reserva->id;
        $opinion->save();

        return redirect()->route('miCuenta')
            ->with('mensaje', '¡Gracias por tu opinión!');
    }


    // ==================================================================
    //  ZONA ADMIN
    // ==================================================================

    // Solo enseña la vista; los datos los pinta DataTables vía AJAX.
    public function mostrarAdmin()
    {
        return view('opinionesAdmin');
    }


    public function listar()
    {
        $opiniones = Opinion::with(['user', 'habitacion'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json([
            'status'    => 200,
            'opiniones' => $opiniones,
        ]);
    }


    public function eliminarAdmin($id)
    {
        $opinion = Opinion::find($id);
        if ($opinion) {
            $opinion->delete();
        }
        return redirect()->route('admin.opiniones');
    }
}
