<?php

//Cada fila significa "esta reserva incluye este servicio".

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TablaReservaServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reserva_servicio')->insert([
            ['idReserva' => 1,  'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 1,  'idServicio' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 2,  'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 5,  'idServicio' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 5,  'idServicio' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 8,  'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 8,  'idServicio' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 11, 'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 11, 'idServicio' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 16, 'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 18, 'idServicio' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 18, 'idServicio' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 21, 'idServicio' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 22, 'idServicio' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 27, 'idServicio' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 27, 'idServicio' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idReserva' => 27, 'idServicio' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
