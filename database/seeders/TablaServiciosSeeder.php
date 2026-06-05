<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaServiciosSeeder extends Seeder
{
    /**
     * Carga servicios típicos del hotel.
     */
    public function run(): void
    {
        DB::table('servicios')->insert([
            [
                'nombre'      => 'Desayuno buffet',
                'descripcion' => 'Desayuno buffet internacional con productos frescos y locales, servido en el restaurante principal.',
                'precio'      => 18.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Spa & Wellness',
                'descripcion' => 'Acceso al spa con piscina cubierta, sauna, baño turco y tratamientos relajantes.',
                'precio'      => 45.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Parking privado',
                'descripcion' => 'Plaza de garaje en parking subterráneo del hotel, con servicio de valet 24h.',
                'precio'      => 15.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Traslado aeropuerto',
                'descripcion' => 'Servicio de transfer privado desde/hacia el aeropuerto internacional Henri Coandă.',
                'precio'      => 35.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Servicio de habitaciones 24h',
                'descripcion' => 'Carta completa de comida y bebida disponible las 24 horas del día.',
                'precio'      => 10.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Lavandería express',
                'descripcion' => 'Servicio de lavandería y planchado con entrega en menos de 24 horas.',
                'precio'      => 12.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Mascotas bienvenidas',
                'descripcion' => 'Servicio pet-friendly: cama, comedero y kit de bienvenida para tu mascota.',
                'precio'      => 25.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nombre'      => 'Cena romántica',
                'descripcion' => 'Cena privada en la habitación con menú degustación y vino seleccionado.',
                'precio'      => 95.00,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
