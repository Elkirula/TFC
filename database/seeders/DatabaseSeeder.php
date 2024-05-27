<?php

namespace Database\Seeders;
use App\Models\Evento;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Evento::create([
            'titulo' => 'Evento 1',
            'descripcion' => 'Descripción del Evento 1',
            'fecha_hora' => now(),
            'user_id' => 1,
            'valoracion_promedio' => 4.5,
        ]);
    
        Evento::create([
            'titulo' => 'Evento 2',
            'descripcion' => 'Descripción del Evento 2',
            'fecha_hora' => now(),
            'user_id' => 1,
            'valoracion_promedio' => 3.8,
        ]);
    }


    
}
