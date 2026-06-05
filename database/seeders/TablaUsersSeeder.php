<?php

/* =====================================================================
 |  Contraseñas por rol:
 |    - Admin          → Admin1234
 |    - Recepcionistas → Recepcion1234
 |    - Clientes       → User1234
 | =====================================================================*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class TablaUsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'nombre'     => 'Ana',
                'apellidos'  => 'Moldovan',
                'email'      => 'anamoldov@gmail.com',
                'telefono'   => '613722270',
                'password'   => Hash::make('Admin1234'),
                'idRol'      => 1,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre'     => 'Carmen',
                'apellidos'  => 'Flores',
                'email'      => 'carmen@gmail.com',
                'telefono'   => '614568146',
                'password'   => Hash::make('Recepcion1234'),
                'idRol'      => 2,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Sergiu',
                'apellidos'  => 'Ungur',
                'email'      => 'sergiungur@gmail.com',
                'telefono'   => '641563214',
                'password'   => Hash::make('Recepcion1234'),
                'idRol'      => 2,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre'     => 'Elisa',
                'apellidos'  => 'Sos',
                'email'      => 'elisasos@gmail.com',
                'telefono'   => '611745894',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre'     => 'Lucia',
                'apellidos'  => 'Garcia',
                'email'      => 'luciagarcia@gmail.com',
                'telefono'   => '611111111',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Ana',
                'apellidos'  => 'Martinez',
                'email'      => 'diegomartinez@gmail.com',
                'telefono'   => '622222222',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Marta',
                'apellidos'  => 'Lopez',
                'email'      => 'martalopez@gmail.com',
                'telefono'   => '633333333',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Pablo',
                'apellidos'  => 'Sanchez',
                'email'      => 'pablosanchez@gmail.com',
                'telefono'   => '644444444',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Sofia',
                'apellidos'  => 'Perez',
                'email'      => 'sofiaperez@gmail.com',
                'telefono'   => '655555555',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Hugo',
                'apellidos'  => 'Romero',
                'email'      => 'hugoromero@gmail.com',
                'telefono'   => '666666666',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Carla',
                'apellidos'  => 'Diaz',
                'email'      => 'carladiaz@gmail.com',
                'telefono'   => '677777777',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Alexandra',
                'apellidos'  => 'Ruiz',
                'email'      => 'alexandra@gmail.com',
                'telefono'   => '688888888',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Laura',
                'apellidos'  => 'Moreno',
                'email'      => 'lauramoreno@gmail.com',
                'telefono'   => '699999999',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Javier',
                'apellidos'  => 'Torres',
                'email'      => 'javiertorres@gmail.com',
                'telefono'   => '600000000',
                'password'   => Hash::make('User1234'),
                'idRol'      => 3,
                'imagenUser' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
