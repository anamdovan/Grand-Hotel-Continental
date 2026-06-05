<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;


class ServiciosController extends Controller
{
    public function mostrar()
    {
        $servicios = Servicio::all();
        return view('servicios', ['servicios' => $servicios]);
    }

//----------------------LISTAR API-----------------------------------
    public function listar(){
        $servicios = Servicio::all();

        return response()->json([
            'status' => 200,
            'servicios' => $servicios
        ]);
    }

    public function mostrarFormIns()
    {
        return view('formularioServicio');
    }


    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'      => ['required', 'string'],    // ej: "Spa & Wellness"
            'descripcion' => ['nullable', 'string'],    // opcional
            'precio'      => ['required', 'numeric'],   // ej: 45.00
        ]);

        $servicio              = new Servicio();
        $servicio->nombre      = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio      = $request->precio;
        $servicio->save();

        return redirect('/admin/servicios');
    }


    public function mostrarFormEd($id)
    {
        $servicio = Servicio::where('id', $id)->first();
        return view('formularioServicio', ['servicio' => $servicio]);
    }

    public function editar($id, Request $request)
    {
        $request->validate([
            'nombre'      => ['required', 'string'],
            'descripcion' => ['nullable', 'string'],
            'precio'      => ['required', 'numeric'],
        ]);

        $servicio              = Servicio::where('id', $id)->first();
        $servicio->nombre      = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->precio      = $request->precio;
        $servicio->save();

        return redirect('/admin/servicios');
    }


    public function eliminar($id)
    {
        $servicio = Servicio::where('id', $id)->first();
        $servicio->delete();
        return redirect('/admin/servicios');
    }
}
