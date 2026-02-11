<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Brand;
use App\Models\Team;
use App\Models\Car;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Usuario Admin (Jairo)
        $admin = User::firstOrCreate(
            ['email' => 'admin@f1ganga.com'],
            [
                'name' => 'Admin Misael',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Crear Marcas (Julio)
        $ferrari = Brand::create(['name' => 'Ferrari', 'country' => 'Italy']);
        $mercedes = Brand::create(['name' => 'Mercedes', 'country' => 'Germany']);
        $redbull = Brand::create(['name' => 'Red Bull Racing', 'country' => 'Austria']);

        // 3. Crear Equipos (Julio)
        $scuderia = Team::create(['name' => 'Scuderia Ferrari', 'principal' => 'Frédéric Vasseur']);
        $amg = Team::create(['name' => 'Mercedes-AMG PETRONAS', 'principal' => 'Toto Wolff']);

        // 4. Crear Coches (Julio)
        $car1 = Car::create([
            'model' => 'SF-24',
            'brand_id' => $ferrari->id,
            'team_id' => $scuderia->id,
            'price' => 12000000.00,
            'description' => 'El monoplaza de Ferrari para la temporada 2024.',
            'year' => 2024
        ]);

        $car2 = Car::create([
            'model' => 'W15',
            'brand_id' => $mercedes->id,
            'team_id' => $amg->id,
            'price' => 11500000.00,
            'description' => 'Flecha de plata con innovaciones aerodinámicas.',
            'year' => 2024
        ]);

        // 5. Llamar al Seeder de Reseñas (Misael)
        $this->call([
            ReviewSeeder::class,
            UserSeeder::class,
        ]);
    }
}
