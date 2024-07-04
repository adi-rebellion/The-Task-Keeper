<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'task_id' => Task::factory(),
            'subject' => $this->faker->sentence,
            'note' => $this->faker->paragraph,
        ];
    }
}
