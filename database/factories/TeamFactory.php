<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $teams = [
            ['name' => 'Scuderia Ferrari', 'principal' => 'Frédéric Vasseur'],
            ['name' => 'Mercedes-AMG PETRONAS', 'principal' => 'Toto Wolff'],
            ['name' => 'Red Bull Racing', 'principal' => 'Christian Horner'],
            ['name' => 'McLaren F1 Team', 'principal' => 'Andrea Stella'],
            ['name' => 'Aston Martin Aramco', 'principal' => 'Mike Krack'],
            ['name' => 'BWT Alpine F1 Team', 'principal' => 'Oliver Oakes'],
            ['name' => 'Williams Racing', 'principal' => 'James Vowles'],
            ['name' => 'Haas F1 Team', 'principal' => 'Ayao Komatsu'],
            ['name' => 'Stake F1 Team Sauber', 'principal' => 'Alessandro Alunni Bravi'],
            ['name' => 'Visa Cash App RB', 'principal' => 'Laurent Mekies'],
        ];

        $team = $this->faker->unique()->randomElement($teams);

        return [
            'name' => $team['name'],
            'principal' => $team['principal'],
        ];
    }
}
