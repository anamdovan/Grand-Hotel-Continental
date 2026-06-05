<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;        
use App\Models\Reserva;  


class PagosController extends Controller
{

    public function mostrar()
    {
        $pagos = Pago::all();
        return view('pagos', ['pagos' => $pagos]);
    }


    public function mostrarFormIns()
    {
        $reservas = Reserva::all();
        return view('formularioPago', ['reservas' => $reservas]);
    }


    public function insertar(Request $request)
    {
        $request->validate([
            'monto'     => ['required', 'numeric'],   
            'metodo'    => ['required', 'string'],    
            'estado'    => ['required', 'string'],    
            'idReserva' => ['required', 'integer'], 
        ]);

        $pago            = new Pago();
        $pago->monto     = $request->monto;
        $pago->metodo    = $request->metodo;
        $pago->estado    = $request->estado;
        $pago->idReserva = $request->idReserva;
        $pago->save();

        return redirect('/admin/pagos');
    }


    public function mostrarFormEd($id)
    {
        $pago     = Pago::where('id', $id)->first();
        $reservas = Reserva::all();
        return view('formularioPago', [
            'pago'     => $pago,
            'reservas' => $reservas
        ]);
    }

    public function editar($id, Request $request)
    {
        $request->validate([
            'monto'     => ['required', 'numeric'],
            'metodo'    => ['required', 'string'],
            'estado'    => ['required', 'string'],
            'idReserva' => ['required', 'integer'],
        ]);

        $pago            = Pago::where('id', $id)->first();
        $pago->monto     = $request->monto;
        $pago->metodo    = $request->metodo;
        $pago->estado    = $request->estado;
        $pago->idReserva = $request->idReserva;
        $pago->save();

        return redirect('/admin/pagos');
    }


    public function eliminar($id)
    {
        $pago = Pago::where('id', $id)->first();
        $pago->delete();
        return redirect('/admin/pagos');
    }
}
