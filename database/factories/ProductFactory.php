<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),
            'preco' => $this->faker->randomFloat(2, 50, 5000),
            'estoque' => $this->faker->numberBetween(1, 100),
            'marca' => $this->faker->company(),
            'categoria' => $this->faker->randomElement(['Teclado', 'Mouse', 'GPU', 'Monitor']),
            'tipo' => $this->faker->word(),
            'user_id' => User::where('is_admin', 0)->inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}