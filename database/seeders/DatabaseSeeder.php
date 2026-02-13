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
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Admin Misael',
            'email' => 'admin@f1ganga.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Regular Users
        User::create([
            'name' => 'Carlos Sainz Jr',
            'email' => 'carlos@f1ganga.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Lewis Hamilton',
            'email' => 'lewis@f1ganga.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Brands
        $ferrari = Brand::create(['name' => 'Ferrari', 'country' => 'Italy']);
        $mercedes = Brand::create(['name' => 'Mercedes', 'country' => 'Germany']);
        $redbull = Brand::create(['name' => 'Red Bull', 'country' => 'Austria']);
        $mclaren = Brand::create(['name' => 'McLaren', 'country' => 'United Kingdom']);
        
        // Teams
        $scuderia = Team::create(['name' => 'Scuderia Ferrari', 'principal' => 'Frédéric Vasseur']);
        $amg = Team::create(['name' => 'Mercedes-AMG PETRONAS', 'principal' => 'Toto Wolff']);
        $rbr = Team::create(['name' => 'Red Bull Racing', 'principal' => 'Christian Horner']);
        $mcl = Team::create(['name' => 'McLaren F1 Team', 'principal' => 'Andrea Stella']);

        // 8 F1 Cars with detailed specs and Unsplash images
        $cars = [
            [
                'model' => 'SF-24',
                'brand_id' => $ferrari->id,
                'team_id' => $scuderia->id,
                'price' => 12500000,
                'year' => 2024,
                'description' => 'El monoplaza más avanzado de Ferrari con innovaciones aerodinámicas revolucionarias para la temporada 2024.',
                'image_url' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&h=600&fit=crop',
                'top_speed' => 350,
                'acceleration' => 2.5,
                'engine' => 'V6 Turbo Hybrid 1.6L',
                'horsepower' => 1050,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'W15',
                'brand_id' => $mercedes->id,
                'team_id' => $amg->id,
                'price' => 11800000,
                'year' => 2024,
                'description' => 'La Flecha de Plata con sistema híbrido de última generación y aerodinámica optimizada.',
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
                'top_speed' => 345,
                'acceleration' => 2.6,
                'engine' => 'V6 Turbo Hybrid 1.6L',
                'horsepower' => 1040,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'RB20',
                'brand_id' => $redbull->id,
                'team_id' => $rbr->id,
                'price' => 13200000,
                'year' => 2024,
                'description' => 'Dominador absoluto con tecnología de punta en fondo plano y gestión de neumáticos superior.',
                'image_url' => 'https://images.unsplash.com/photo-1628888002116-ac1c6c0d5e06?w=800&h=600&fit=crop',
                'top_speed' => 355,
                'acceleration' => 2.4,
                'engine' => 'Honda RBPT V6 Turbo 1.6L',
                'horsepower' => 1060,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'MCL60',
                'brand_id' => $mclaren->id,
                'team_id' => $mcl->id,
                'price' => 10500000,
                'year' => 2024,
                'description' => 'Diseño papaya con eficiencia aerodinámica excepcional y chasis ultraligero de fibra de carbono.',
                'image_url' => 'https://images.unsplash.com/photo-1541443131876-44b03de101c5?w=800&h=600&fit=crop',
                'top_speed' => 340,
                'acceleration' => 2.7,
                'engine' => 'Mercedes V6 Turbo 1.6L',
                'horsepower' => 1035,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'SF-23',
                'brand_id' => $ferrari->id,
                'team_id' => $scuderia->id,
                'price' => 9800000,
                'year' => 2023,
                'description' => 'Modelo anterior de Ferrari perfectamente mantenido, ideal para coleccionistas y entusiastas.',
                'image_url' => 'https://images.unsplash.com/photo-1610768764270-790fbec18178?w=800&h=600&fit=crop',
                'top_speed' => 348,
                'acceleration' => 2.6,
                'engine' => 'V6 Turbo Hybrid 1.6L',
                'horsepower' => 1045,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'W14',
                'brand_id' => $mercedes->id,
                'team_id' => $amg->id,
                'price' => 9200000,
                'year' => 2023,
                'description' => 'Evolución de la leyenda plateada con recuperación de energía mejorada y DRS optimizado.',
                'image_url' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=800&h=600&fit=crop',
                'top_speed' => 343,
                'acceleration' => 2.7,
                'engine' => 'V6 Turbo Hybrid 1.6L',
                'horsepower' => 1038,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'RB19',
                'brand_id' => $redbull->id,
                'team_id' => $rbr->id,
                'price' => 14500000,
                'year' => 2023,
                'description' => 'Campeón invicto de 2023, récord de victorias consecutivas. Una leyenda moderna del automovilismo.',
                'image_url' => 'https://images.unsplash.com/photo-1592853611284-f2bb6e12a47d?w=800&h=600&fit=crop',
                'top_speed' => 353,
                'acceleration' => 2.3,
                'engine' => 'Honda RBPT V6 Turbo 1.6L',
                'horsepower' => 1058,
                'transmission' => '8-speed semi-automatic',
            ],
            [
                'model' => 'MCL35M',
                'brand_id' => $mclaren->id,
                'team_id' => $mcl->id,
                'price' => 7800000,
                'year' => 2022,
                'description' => 'McLaren histórico con motor Mercedes. Excelente relación calidad-precio para iniciarse en F1.',
                'image_url' => 'https://images.unsplash.com/photo-1595348020949-87cdfbb44174?w=800&h=600&fit=crop',
                'top_speed' => 338,
                'acceleration' => 2.8,
                'engine' => 'Mercedes V6 Turbo 1.6L',
                'horsepower' => 1030,
                'transmission' => '8-speed semi-automatic',
            ],
        ];

        $imageService = new \App\Services\ImageService();

        foreach ($cars as $carData) {
            // Forzar búsqueda dinámica de imagen si hay API Key, si no mantiene la de Unsplash fija
            $dynamicImage = $imageService->getCarImage($carData['model']);
            if ($dynamicImage) {
                $carData['image_url'] = $dynamicImage;
            }
            Car::create($carData);
        }

        // Call other seeders
        $this->call([
            ReviewSeeder::class,
        ]);
    }
}
