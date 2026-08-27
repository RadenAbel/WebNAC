<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    public function definition(): array
    {
        $role = fake()->randomElement(['pelatih', 'atlet']);

        $category = $role === 'pelatih'
            ? fake()->randomElement(['Head Coach', 'Assistant Coach', 'Fitness Coach'])
            : fake()->randomElement(['Junior', 'Senior', 'Swim Class A', 'Swim Class B']);

        return [
            'name'       => fake()->name(),
            'photo'      => null,
            'age'        => fake()->numberBetween($role === 'pelatih' ? 28 : 10, $role === 'pelatih' ? 55 : 24),
            'role'       => $role,
            'category'   => $category,
            'bio'        => fake()->sentence(12),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active'  => true,
        ];
    }

    /**
     * State: paksa jadi pelatih
     */
    public function pelatih(): static
    {
        return $this->state(fn () => [
            'role'     => 'pelatih',
            'category' => fake()->randomElement(['Head Coach', 'Assistant Coach', 'Fitness Coach']),
            'age'      => fake()->numberBetween(28, 55),
        ]);
    }

    /**
     * State: paksa jadi atlet
     */
    public function atlet(): static
    {
        return $this->state(fn () => [
            'role'     => 'atlet',
            'category' => fake()->randomElement(['Junior', 'Senior', 'Swim Class A', 'Swim Class B']),
            'age'      => fake()->numberBetween(10, 24),
        ]);
    }
}