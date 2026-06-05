<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * IMPORTANTE: el orden importa por las FOREIGN KEYS.
     *   1º Roles                → independiente
     *   2º Users                → FK a roles
     *   3º Habitaciones         → independiente
     *   4º Servicios            → independiente
     *   5º Reservas             → FK a users y a habitaciones
     *   6º ReservaServicio      → FK a reservas y a servicios (tabla pivote N:M)
     *   7º Opiniones            → FK a users, habitaciones y reservas
     */
    public function run(): void
    {
        $this->call([
            TablaRolesSeeder::class,
            TablaUsersSeeder::class,
            TablaHabitacionesSeeder::class,
            TablaServiciosSeeder::class,
            TablaReservasSeeder::class,
            TablaReservaServicioSeeder::class,
            TablaOpinionesSeeder::class,
        ]);
    }
}
