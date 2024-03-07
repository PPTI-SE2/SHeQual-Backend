<?php

namespace Database\Factories;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultant>
 */
class ConsultantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $user = User::inRandomOrder()->first();
        
        $alreadyConsultant = Consultant::where('users_id', $user->id)->exists();

        if (!$alreadyConsultant) {
            return [
                'users_id' => $user->id,
                'patients' => fake()->numberBetween(0,999),
                'experience' => fake()->numberBetween(0,15),
                'bio_data' => fake()->text,
                'status' => fake()->text(10),
            ];
        }
    }
}
