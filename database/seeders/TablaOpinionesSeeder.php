<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TablaOpinionesSeeder extends Seeder
{
    public function run(): void
    {
        // Año anterior, igual que las reservas
        $a = Carbon::now()->year - 1;

        DB::table('opiniones')->insert([

            // ============ OPINIONES BUENAS ============
            [
                'puntuacion'   => 5,
                'comentario'   => 'Una estancia maravillosa, el servicio fue excelente y la habitación impecable. Volveremos pronto.',
                'idUser'       => 4,
                'idHabitacion' => 5,
                'idReserva'    => 1,
                'created_at'   => Carbon::create($a, 12, 20),
                'updated_at'   => Carbon::create($a, 12, 20),
            ],
            [
                'puntuacion'   => 5,
                'comentario'   => 'Repetiremos sin duda. Los detalles de lujo se notan en cada rincón de la habitación.',
                'idUser'       => 5,
                'idHabitacion' => 3,
                'idReserva'    => 2,
                'created_at'   => Carbon::create($a, 11, 26),
                'updated_at'   => Carbon::create($a, 11, 26),
            ],
            [
                'puntuacion'   => 4,
                'comentario'   => 'Increíble experiencia. El personal súper atento. La cama, una nube.',
                'idUser'       => 6,
                'idHabitacion' => 2,
                'idReserva'    => 3,
                'created_at'   => Carbon::create($a, 10, 17),
                'updated_at'   => Carbon::create($a, 10, 17),
            ],
            [
                'puntuacion'   => 5,
                'comentario'   => 'Vistas espectaculares al bulevar Victoriei. Recomendable 100%. Una joya en el centro de Bucarest.',
                'idUser'       => 7,
                'idHabitacion' => 4,
                'idReserva'    => 4,
                'created_at'   => Carbon::create($a,  9, 11),
                'updated_at'   => Carbon::create($a,  9, 11),
            ],
            [
                'puntuacion'   => 4,
                'comentario'   => 'Servicio impecable y desayuno espectacular. Volveremos en nuestras próximas vacaciones.',
                'idUser'       => 8,
                'idHabitacion' => 6,
                'idReserva'    => 5,
                'created_at'   => Carbon::create($a,  8, 23),
                'updated_at'   => Carbon::create($a,  8, 23),
            ],
            [
                'puntuacion'   => 5,
                'comentario'   => 'La mejor habitación que hemos tenido en Bucarest. Limpieza perfecta y atención al detalle.',
                'idUser'       => 9,
                'idHabitacion' => 1,
                'idReserva'    => 6,
                'created_at'   => Carbon::create($a,  7, 29),
                'updated_at'   => Carbon::create($a,  7, 29),
            ],

            // ============ OPINIONES NEUTRAS ============
            [
                'puntuacion'   => 3,
                'comentario'   => 'Habitación correcta, sin más. Cumple lo que promete pero esperaba algo más por el precio.',
                'idUser'       => 10,
                'idHabitacion' => 3,
                'idReserva'    => 7,
                'created_at'   => Carbon::create($a,  6, 18),
                'updated_at'   => Carbon::create($a,  6, 18),
            ],
            [
                'puntuacion'   => 3,
                'comentario'   => 'Bien situado pero la habitación es algo pequeña. El desayuno podría mejorar la variedad.',
                'idUser'       => 11,
                'idHabitacion' => 5,
                'idReserva'    => 8,
                'created_at'   => Carbon::create($a,  5, 15),
                'updated_at'   => Carbon::create($a,  5, 15),
            ],

            // ============ OPINIONES MALAS ============
            [
                'puntuacion'   => 2,
                'comentario'   => 'La habitación estaba sucia al llegar y el servicio fue muy lento. Decepcionante para un cinco estrellas.',
                'idUser'       => 12,
                'idHabitacion' => 2,
                'idReserva'    => 9,
                'created_at'   => Carbon::create($a,  4, 26),
                'updated_at'   => Carbon::create($a,  4, 26),
            ],
            [
                'puntuacion'   => 1,
                'comentario'   => 'No corresponde con las fotos. Mucho ruido del pasillo y aire acondicionado que no funcionaba. No volveré.',
                'idUser'       => 13,
                'idHabitacion' => 4,
                'idReserva'    => 10,
                'created_at'   => Carbon::create($a,  3, 21),
                'updated_at'   => Carbon::create($a,  3, 21),
            ],
        ]);
    }
}
