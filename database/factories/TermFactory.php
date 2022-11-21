<?php

namespace Database\Factories;

use App\Models\Term\Term;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Term>
 */
class TermFactory extends Factory
{
    protected $model = Term::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'term' => fake()->unique()->jobTitle(),
            'rating' => fake()->numberBetween(1, 8),
            'description' => fake()->paragraph()
        ];
    }
}
