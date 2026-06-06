<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Session;
use App\Models\User;            
use Illuminate\Support\Facades\Hash; 

class SesionController extends Controller
{
   
    public function mostrar()
    {
        return view('inicioSesion');
    }


    public function iniciarSesion(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'string'],  
            'password' => ['required', 'string'],  
        ]);

        // Auth::attempt() busca en la tabla 'users' un usuario con ese email,
        if (Auth::attempt($credenciales)) {

            //regenerar el ID de sesión.
            // Esto evita ataques de "session fixation": si alguien hubiera
            // robado tu cookie ANTES del login, ahora ya no le sirve
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->rol->tipoRol == 'admin' || $user->rol->tipoRol == 'recepcionista') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/miCuenta');
            }

        } else {
            //Si las credenciales son malas
            // Volvemos a mostrar la vista de login pero con un mensaje de error.
            $errormsg = "El email o la contraseña no son correctos.";
            return view('inicioSesion', [
                'errormsg' => $errormsg
            ]);
        }
    }


    // ===================================================================
    // MOSTRAR FORMULARIO DE REGISTRO
    //  --------------------------------------------------------------
   
    public function mostrarRegistro()
    {
        return view('formularioRegistro');
    }


    // ===================================================================
    //  REGISTRO - Crea un nuevo usuario en la BBDD
    //  --------------------------------------------------------------
    // 
    public function registro(Request $request)
    {
        $request->validate([
            'email'      => ['required', 'string'],
            'password'   => ['required', 'string'],
            'rePassword' => ['required', 'string'],
            'nombre'     => ['required', 'string'],
            'apellidos'  => ['required', 'string'],
            'telefono'   => ['nullable', 'string'],   
        ]);

        //Comprobar que las dos contraseñas coinciden
        if ($request->password == $request->rePassword) {

            if (User::where('email', $request->email)->first() != null) {
                $errormsg = "Este email ya está registrado.";
                return view('formularioRegistro', [
                    'errormsg' => $errormsg
                ]);
            }

            //Crea el nuevo usuario
            $usuario            = new User();
            $usuario->idRol     = 3;   
            $usuario->email     = $request->email;
            $usuario->password  = Hash::make($request->password);
            $usuario->nombre    = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->telefono  = $request->telefono;
            $usuario->save();

            //Iniciar sesión automáticamente con el usuario recién creado.
            //Así no le hagp teclear de nuevo email y password.
            Auth::login($usuario);

            //Redirigir a su zona personal
            return redirect('/miCuenta');

        } else {
            // Las contraseñas no coinciden → volver al formulario
            $errormsg = "Las contraseñas no coinciden.";
            return view('formularioRegistro', [
                'errormsg' => $errormsg
            ]);
        }
    }


    // ===================================================================
    //  CERRAR SESIÓN (logout)
    //  --------------------------------------------------------------
    //
    public function cerrarSesion()
    {
        // Session::flush() borra TODOS los datos guardados en la sesión
        Session::flush();

        // Auth::logout() invalida la sesión del usuario
        Auth::logout();

        // Devolvemos al usuario al formulario de login.
        return redirect('/login');
    }
}
