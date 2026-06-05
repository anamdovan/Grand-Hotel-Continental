<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaHabitacionesSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('habitaciones')->insert([
            [
                'numero'      => '101',
                'tipo'        => 'Estándar',
                'precio'      => 89.00,
                'descripcion' => 'Habitación cómoda y acogedora con cama individual, baño privado y vista a la ciudad. Perfecta para viajeros de negocios o estancias cortas.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'numero'      => '201',
                'tipo'        => 'Doble',
                'precio'      => 130.00,
                'descripcion' => 'Espaciosa habitación doble con cama king-size, baño de mármol y minibar. Ideal para parejas que buscan elegancia y comodidad.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'numero'      => '301',
                'tipo'        => 'Deluxe Matrimonial',
                'precio'      => 195.00,
                'descripcion' => 'Habitación deluxe con cama matrimonial king-size, vistas al bulevar Victoriei, salita de descanso y baño de mármol con bañera y ducha.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'numero'      => '302',
                'tipo'        => 'Deluxe Twin',
                'precio'      => 195.00,
                'descripcion' => 'Habitación deluxe con dos camas individuales, perfecta para amigos o compañeros de viaje que comparten habitación. Mismo lujo que la Deluxe Matrimonial.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'numero'      => '401',
                'tipo'        => 'Suite',
                'precio'      => 320.00,
                'descripcion' => 'Suite Premium con sala de estar separada, jacuzzi privado, terraza y servicio de mayordomo personalizado. Espacio amplio para vivir una experiencia inolvidable.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'numero'      => '501',
                'tipo'        => 'Suite Presidencial',
                'precio'      => 480.00,
                'descripcion' => 'Suite Presidencial: el máximo lujo del hotel. Vista panorámica de Bucarest, terraza privada, dormitorio principal, sala de estar, comedor y servicio exclusivo 24 horas.',
                'imagenHab'   => null,
                'estado'      => 'disponible',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            // Habitación en mantenimiento
            [
                'numero'      => '102',
                'tipo'        => 'Estándar',
                'precio'      => 89.00,
                'descripcion' => 'Habitación estándar en renovación.',
                'imagenHab'   => null,
                'estado'      => 'mantenimiento',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
