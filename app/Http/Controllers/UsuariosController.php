<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rol;


class UsuariosController extends Controller
{

    public function mostrar()
    {
        $usuarios = User::with('rol')->get();
        return view('usuarios', ['usuarios' => $usuarios]);
    }


    public function listar()
    {
       
        $usuarios = User::with('rol')->get()->map(function ($u) {
            return [
                'id'        => $u->id,
                'nombre'    => $u->nombre,
                'apellidos' => $u->apellidos,
                'email'     => $u->email,
                'telefono'  => $u->telefono,
                'rol'       => optional($u->rol)->tipoRol,   // null-safe
                'idRol'     => $u->idRol,
            ];
        });

        return response()->json([
            'status'   => 200,
            'usuarios' => $usuarios,
        ]);
    }


    public function mostrarFormIns()
    {
        // Necesitamos los roles para que el admin elija cuál asignar.
        $roles = Rol::all();
        return view('formularioUsuario', [
            'usuario' => null,   // null indica "modo crear"
            'roles'   => $roles,
        ]);
    }


    public function insertar(Request $request)
    {
        // Validación de los datos del formulario.
        $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'telefono'  => ['nullable', 'string', 'max:20'],
            'password'  => ['required', 'string', 'min:8'],
            'idRol'     => ['required', 'exists:roles,id'],
        ], [
            'email.unique'  => 'Ya existe un usuario con ese email.',
            'password.min'  => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $u = new User();
        $u->nombre    = $request->nombre;
        $u->apellidos = $request->apellidos;
        $u->email     = $request->email;
        $u->telefono  = $request->telefono;
        $u->password  = $request->password;
        $u->idRol     = $request->idRol;
        $u->save();

        return redirect('/admin/usuarios')
            ->with('mensaje', 'Usuario creado correctamente.');
    }



    public function mostrarFormEd($id)
    {
        $usuario = User::find($id);

        // Si el usuario no existe, redirigir con mensaje de error.
        if (!$usuario) {
            return redirect('/admin/usuarios')
                ->with('error', 'Usuario no encontrado.');
        }

        $roles = Rol::all();
        return view('formularioUsuario', [
            'usuario' => $usuario,
            'roles'   => $roles,
        ]);
    }


    //  editar($id)
    //  Guarda los cambios del usuario editado.

    public function editar($id, Request $request)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return redirect('/admin/usuarios')
                ->with('error', 'Usuario no encontrado.');
        }

        // Validación. El email único debe ignorar el propio id.
        $request->validate([
            'nombre'    => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email,' . $id],
            'telefono'  => ['nullable', 'string', 'max:20'],
            'password'  => ['nullable', 'string', 'min:8'],   // opcional al editar
            'idRol'     => ['required', 'exists:roles,id'],
        ]);

        // Actualizar campos.
        $usuario->nombre    = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email     = $request->email;
        $usuario->telefono  = $request->telefono;
        $usuario->idRol     = $request->idRol;

        // Solo actualizar la contraseña si el admin la ha rellenado.
        // De esta forma, dejar el campo en blanco al editar mantiene la
        // contraseña actual del usuario.
        if (!empty($request->password)) {
            $usuario->password = $request->password;
        }

        $usuario->save();

        return redirect('/admin/usuarios')
            ->with('mensaje', 'Usuario actualizado correctamente.');
    }


    public function eliminar($id)
    {
        //el admin no se puede borrar a sí mismo.
        if ($id == Auth::id()) {
            return redirect('/admin/usuarios')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario = User::find($id);
        if (!$usuario) {
            return redirect('/admin/usuarios')
                ->with('error', 'Usuario no encontrado.');
        }

        $usuario->delete();

        return redirect('/admin/usuarios')
            ->with('mensaje', 'Usuario eliminado correctamente.');
    }
}
