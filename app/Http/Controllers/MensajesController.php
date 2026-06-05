<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;


class MensajesController extends Controller
{
    // ==================================================================
    //  ZONA PÚBLICA
    // ==================================================================


    public function mostrarFormulario()
    {
        return view('contacto');
    }


    public function enviar(Request $request)
    {
        $request->validate([
            'nombre'   => ['required', 'string'],
            'email'    => ['required', 'email'],
            'telefono' => ['nullable', 'string'],
            'asunto'   => ['required', 'string'],
            'mensaje'  => ['required', 'string'],
        ], [
            'nombre.required'  => 'El nombre es obligatorio.',
            'email.required'   => 'El email es obligatorio.',
            'email.email'      => 'El formato del email no es válido.',
            'asunto.required'  => 'El asunto es obligatorio.',
            'mensaje.required' => 'El mensaje es obligatorio.',
        ]);

        $msg = new Mensaje();
        $msg->nombre   = $request->nombre;
        $msg->email    = $request->email;
        $msg->telefono = $request->telefono;
        $msg->asunto   = $request->asunto;
        $msg->mensaje  = $request->mensaje;

        // ============================================================
        //  Si el visitante está logueado, guardo su id como
        //  remitente. Si es un visitante anónimo, se queda a NULL
        //  (la columna es nullable en la migración).
        // ============================================================
        if (Auth::check()) {
            $msg->idUsuarioRemitente = Auth::id();
        }

        $msg->save();

        return redirect()->route('contacto')
            ->with('mensaje', '¡Mensaje enviado! Te responderemos en breve.');
    }


    // ==================================================================
    //  ZONA ADMIN
    // ==================================================================


    public function mostrarAdmin()
    {
        return view('mensajesAdmin');
    }


    public function listar()
    {
        $mensajes = Mensaje::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status'   => 200,
            'mensajes' => $mensajes,
        ]);
    }


    public function mostrarResponder($id)
    {
        $msg = Mensaje::find($id);
        if (!$msg) {
            return redirect()->route('admin.mensajes')
                ->with('error', 'Mensaje no encontrado.');
        }

        return view('mensajeResponder', ['msg' => $msg]);
    }

    public function guardarRespuesta($id, Request $request)
    {
        // Validación servidor
        $request->validate([
            'respuesta' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $msg = Mensaje::find($id);
        if (!$msg) {
            return redirect()->route('admin.mensajes')
                ->with('error', 'Mensaje no encontrado.');
        }

        $msg->respuesta      = $request->respuesta;
        $msg->fechaRespuesta = now();

        // ============================================================
        //  Guardo quién respondió (recepcionista o admin logueado).
        // ============================================================
        $msg->idUsuarioRespuesta = Auth::id();

        $msg->save();

        return redirect()->route('admin.mensajes')
            ->with('mensaje', '¡Respuesta guardada! Recuerda enviarla desde tu correo si es necesario.');
    }


    public function eliminar($id)
    {
        $msg = Mensaje::find($id);
        if ($msg) $msg->delete();
        return redirect()->route('admin.mensajes');
    }
}
