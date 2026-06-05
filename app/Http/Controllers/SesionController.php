<?php

/* =====================================================================
 |  SesionController.php
 |  ---------------------------------------------------------------------
 |  CONTROLADOR encargado de TODO lo relacionado con la sesión del usuario:
 |    - Mostrar el formulario de login
 |    - Procesar el login (validar credenciales)
 |    - Mostrar el formulario de registro
 |    - Procesar el registro (crear nuevo usuario)
 |    - Cerrar sesión (logout)
 |
 |  Lo usan las rutas declaradas en routes/web.php para /login y /registro.
 | =====================================================================*/

namespace App\Http\Controllers;

// ----- Clases que vamos a usar (imports) -----
use Illuminate\Http\Request;                // Para acceder a los datos del formulario ($request->email, etc.)
use Illuminate\Support\Facades\Auth;        // Facade de autenticación (login, logout, comprobar sesión...)
use Illuminate\Support\Facades\Session;     // Para manipular la sesión (limpiarla al hacer logout)
use App\Models\User;                        // El modelo Eloquent que representa a la tabla 'users'
use Illuminate\Support\Facades\Hash;        // Facade para encriptar contraseñas con bcrypt


class SesionController extends Controller
{
    // ===================================================================
    //  MOSTRAR FORMULARIO DE LOGIN
    //  --------------------------------------------------------------
    //  Se llama cuando el usuario hace GET a /login.
    //  Simplemente devuelve la vista del formulario para que pueda
    //  introducir su email y contraseña.
    // ===================================================================
    public function mostrar()
    {
        // view('inicioSesion') busca el archivo resources/views/inicioSesion.blade.php
        // y devuelve el HTML que se le mostrará al usuario.
        return view('inicioSesion');
    }


    // ===================================================================
    //  INICIAR SESIÓN
    //  --------------------------------------------------------------
    //  Se llama cuando el usuario envía el formulario de login (POST /login).
    //  Comprueba las credenciales y, si son correctas, inicia la sesión.
    //  Luego redirige según el rol del usuario (admin/recepcionista o cliente).
    //
    //  PARÁMETRO:
    //   - $request → contiene los datos enviados desde el formulario
    //                (email y password)
    // ===================================================================
    public function iniciarSesion(Request $request)
    {
        // PASO 1: Validar que los campos llegaron correctamente.
        // Si falta alguno, Laravel redirige automáticamente al formulario
        // mostrando los errores (con la variable $errors).
        $credenciales = $request->validate([
            'email'    => ['required', 'string'],  // email obligatorio, tipo texto
            'password' => ['required', 'string'],  // password obligatorio, tipo texto
        ]);

        // PASO 2: Intentar autenticar al usuario.
        // Auth::attempt() busca en la tabla 'users' un usuario con ese email,
        // hashea la contraseña que el usuario tecleó y la compara con la
        // guardada en BBDD. Devuelve true si coincide, false si no.
        if (Auth::attempt($credenciales)) {

            // PASO 3 (seguridad): regenerar el ID de sesión.
            // Esto evita ataques de "session fixation": si alguien hubiera
            // robado tu cookie ANTES del login, ahora ya no le sirve.
            $request->session()->regenerate();

            // PASO 4: Decidir adónde llevar al usuario según su rol.
            // Auth::user() devuelve el objeto User del usuario logueado.
            // $user->rol es la relación con la tabla 'roles'.
            // $user->rol->tipoRol es la columna 'tipoRol' del rol asociado.
            $user = Auth::user();

            if ($user->rol->tipoRol == 'admin' || $user->rol->tipoRol == 'recepcionista') {
                // Si es admin o recepcionista → al dashboard
                return redirect('/admin/dashboard');
            } else {
                // Si es cliente (rol 3) → a su zona personal
                return redirect('/miCuenta');
            }

        } else {
            // PASO 5: Si Auth::attempt() devolvió false, las credenciales son malas.
            // Volvemos a mostrar la vista de login pero con un mensaje de error.
            // El segundo parámetro de view() es un array de variables que se
            // pasan a la vista (allí accederás con {{ $errormsg }}).
            $errormsg = "El email o la contraseña no son correctos.";
            return view('inicioSesion', [
                'errormsg' => $errormsg
            ]);
        }
    }


    // ===================================================================
    // MOSTRAR FORMULARIO DE REGISTRO
    //  --------------------------------------------------------------
    //  GET /registro → muestra el formulario para crear cuenta nueva.
    // ===================================================================
    public function mostrarRegistro()
    {
        return view('formularioRegistro');
    }


    // ===================================================================
    //  REGISTRO - Crea un nuevo usuario en la BBDD
    //  --------------------------------------------------------------
    //  POST /registro → procesa el formulario de registro.
    //  Crea un nuevo usuario con rol 'cliente' por defecto y lo loguea
    //  automáticamente.
    // ===================================================================
    public function registro(Request $request)
    {
        // PASO 1: Validar que todos los campos obligatorios llegaron.
        // 'nullable' significa que ese campo puede venir vacío.
        $request->validate([
            'email'      => ['required', 'string'],
            'password'   => ['required', 'string'],
            'rePassword' => ['required', 'string'],
            'nombre'     => ['required', 'string'],
            'apellidos'  => ['required', 'string'],
            'telefono'   => ['nullable', 'string'],   // teléfono es opcional
        ]);

        // PASO 2: Comprobar que las dos contraseñas coinciden
        // (validación de negocio que no hace Laravel por sí solo).
        if ($request->password == $request->rePassword) {

            // PASO 3: Verificar que ese email NO esté ya registrado.
            // User::where('email', $email)->first() busca el primer usuario
            // con ese email. Si no existe, devuelve null.
            if (User::where('email', $request->email)->first() != null) {
                // Si existe → volver al formulario con mensaje de error
                $errormsg = "Este email ya está registrado.";
                return view('formularioRegistro', [
                    'errormsg' => $errormsg
                ]);
            }

            // PASO 4: Crear el nuevo usuario.
            // Instanciamos el modelo User y asignamos los campos uno a uno.
            $usuario            = new User();
            $usuario->idRol     = 3;                          // 3 = cliente (definido en TablaRolesSeeder)
            $usuario->email     = $request->email;
            // CRÍTICO: NUNCA guardar la contraseña en texto plano.
            // Hash::make() la encripta con bcrypt antes de guardarla.
            $usuario->password  = Hash::make($request->password);
            $usuario->nombre    = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->telefono  = $request->telefono;
            // save() ejecuta el INSERT en la BBDD.
            $usuario->save();

            // PASO 5: Iniciar sesión automáticamente con el usuario recién creado.
            // Así no le hacemos teclear de nuevo email y password.
            Auth::login($usuario);

            // PASO 6: Redirigir a su zona personal.
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
    //  GET /logout → borra los datos de la sesión y manda al login.
    // ===================================================================
    public function cerrarSesion()
    {
        // Session::flush() borra TODOS los datos guardados en la sesión
        // (variables custom, mensajes flash, etc.).
        Session::flush();

        // Auth::logout() invalida la sesión del usuario.
        // Tras esto, Auth::check() devuelve false y @auth en Blade no se renderiza.
        Auth::logout();

        // Devolvemos al usuario al formulario de login.
        return redirect('/login');
    }
}
