<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;      
use App\Models\Servicio;       


class HabitacionesController extends Controller
{

    public function mostrar()
    {
        $habitaciones = Habitacion::all();
        return view('habitaciones', ['habitaciones' => $habitaciones]);
    }

    //----------------------LISTAR API-----------------------------------
    public function listar(){
        $habitaciones = Habitacion::all();

        return response()->json([
            'status' => 200,
            'habitaciones' => $habitaciones
        ]);
    }

    public function mostrarFormIns()
    {
        $servicios = Servicio::all();
        return view('formularioHabitacion', ['servicios' => $servicios]);
    }


    public function insertar(Request $request)
    {
        $request->validate([
            'numero'      => ['required', 'string'],
            'tipo'        => ['required', 'string'],
            'precio'      => ['required', 'numeric'],
            'descripcion' => ['nullable', 'string'],
            'estado'      => ['required', 'string'],
        ]);

        // Crear la habitación nueva
        $habitacion              = new Habitacion();
        $habitacion->numero      = $request->numero;
        $habitacion->tipo        = $request->tipo;
        $habitacion->precio      = $request->precio;
        $habitacion->descripcion = $request->descripcion;
        $habitacion->estado      = $request->estado;
        $habitacion->save();

        return redirect('/admin/habitaciones');
    }


    public function mostrarFormEd($id)
    {
        $habitacion = Habitacion::where('id', $id)->first();
        $servicios  = Servicio::all();
        return view('formularioHabitacion', [
            'habitacion' => $habitacion,
            'servicios'  => $servicios
        ]);
    }


    public function editar($id, Request $request)
    {
        $request->validate([
            'numero'      => ['required', 'string'],
            'tipo'        => ['required', 'string'],
            'precio'      => ['required', 'numeric'],
            'descripcion' => ['nullable', 'string'],
            'estado'      => ['required', 'string'],
        ]);

        // Buscar la habitación existente por su id
        $habitacion              = Habitacion::where('id', $id)->first();
        $habitacion->numero      = $request->numero;
        $habitacion->tipo        = $request->tipo;
        $habitacion->precio      = $request->precio;
        $habitacion->descripcion = $request->descripcion;
        $habitacion->estado      = $request->estado;

        $habitacion->save();

        return redirect('/admin/habitaciones');
    }

    
    public function eliminar($id)
    {
        $habitacion = Habitacion::where('id', $id)->first();

        // Si la habitación no existe, volvemos al listado sin hacer nada
        if (!$habitacion) {
            return redirect('/admin/habitaciones')
                ->with('error', 'La habitación que intentas eliminar no existe.');
        }

        // Comprobamos si tiene reservas asociadas (de cualquier estado)
        if ($habitacion->reservas()->count() > 0) {
            return redirect('/admin/habitaciones')
                ->with('error', 'No se puede eliminar la habitación Nº ' . $habitacion->numero
                    . ' porque tiene reservas asociadas.');
        }

        // Si no tiene reservas, eliminamos
        $numero = $habitacion->numero;
        $habitacion->delete();

        return redirect('/admin/habitaciones')
            ->with('mensaje', 'Habitación Nº ' . $numero . ' eliminada correctamente.');
    }
}
