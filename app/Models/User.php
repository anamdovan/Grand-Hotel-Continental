<?php

/* =====================================================================
 |  User.php
 |  ---------------------------------------------------------------------
 |  MODELO de USUARIO (tabla 'users' en la BBDD).
 |
 |  Cada instancia de User representa una fila de la tabla users.
 |  Hereda de Authenticatable (no de Model) porque Laravel necesita
 |  ciertos métodos extra para gestionar la autenticación: Auth::attempt(),
 |  Auth::login(), Auth::logout(), Auth::user(), etc.
 |
 |  RELACIONES:
 |    - rol()      → CADA usuario tiene UN rol (admin/recepcionista/cliente)
 |    - reservas() → CADA usuario PUEDE tener MUCHAS reservas
 | =====================================================================*/

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    // ------------------------------------------------------------------
    //  $table → indica explícitamente qué tabla representa este modelo.
    //  Si no se pone, Laravel deduce el nombre por convención (User → users).
    // ------------------------------------------------------------------
    protected $table = 'users';


    // ==================================================================
    //  RELACIONES
    // ==================================================================

    /**
     *  Relación "uno a muchos" (hasMany):
     *  Un usuario PUEDE tener MUCHAS reservas a lo largo del tiempo.
     *
     *  El segundo parámetro 'idUser' es la columna FK en la tabla 'reservas'
     *  que apunta a este usuario.
     *
     *  Uso:  $user->reservas  →  Collection de reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'idUser');
    }


    /**
     *  Relación "muchos a uno" (belongsTo):
     *  CADA usuario tiene un rol (admin, recepcionista o cliente).
     *
     *  'idRol' es la columna FK de esta tabla (users) que apunta a roles.
     *
     *  Uso:  $user->rol->tipoRol  →  string 'admin' / 'cliente' / etc.
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }


    /**
     *  hasRole($role)
     *  -----------------------------------------------------------------
     *  Comprueba si este usuario tiene el rol que se le pasa por parámetro.
     *  Lo usa el middleware Role para decidir si dejar pasar al usuario.
     *
     *  Uso:
     *    if ($user->hasRole('admin')) { ... }
     *
     *  @param  string  $role  Nombre del rol ('admin', 'recepcionista', 'cliente')
     *  @return bool           true si tiene ese rol, false si no
     */
    public function hasRole($role): bool
    {
        // $this->rol es la relación; tipoRol es la columna con el nombre del rol
        return $this->rol && $this->rol->tipoRol === $role;
    }


    // ==================================================================
    //  TRAITS y configuración
    // ==================================================================

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    //  ↑ HasFactory: permite generar usuarios de prueba con UserFactory.
    //  ↑ Notifiable: permite mandar notificaciones a este usuario (mail...).


    /**
     *  $fillable → campos que se pueden asignar EN MASA.
     *
     *  Sirve cuando haces User::create([...]) para protegerse del
     *  "mass assignment vulnerability": si llegara un campo extra
     *  (ej: is_admin) en el formulario, Laravel lo ignoraría porque
     *  no está en $fillable.
     */
    protected $fillable = [
        'name',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'imagenUser',
        'password',
        'idRol',
    ];


    /**
     *  $hidden → campos que NO aparecerán cuando el modelo se convierta
     *  a JSON o array (por ejemplo, en APIs).
     *
     *  Aunque la contraseña hasheada esté en BBDD, no se enviará al
     *  navegador por accidente.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     *  casts() → cómo convertir los valores de BBDD a tipos PHP útiles.
     *
     *  - 'email_verified_at' → de string a objeto Carbon (DateTime)
     *  - 'password' → 'hashed' significa que cualquier valor que asignes
     *                 se hashea automáticamente antes de guardar.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
