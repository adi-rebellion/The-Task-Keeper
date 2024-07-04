<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'status' => $this->faker->randomElement(['New', 'Incomplete', 'Complete']),
            'priority' => $this->faker->randomElement(['High', 'Medium', 'Low']),
        ];
    }
}
