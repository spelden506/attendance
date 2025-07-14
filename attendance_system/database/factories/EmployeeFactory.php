<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_id' => 'YK' . $this->faker->unique()->numberBetween(100, 999),
            'name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'department' => $this->faker->randomElement(['Technology', 'Human Resources', 'Finance', 'Sales & Marketing']),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}