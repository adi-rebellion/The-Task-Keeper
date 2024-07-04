<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            Note::factory(3)->create(['task_id' => $task->id]); // Create 3 notes for each task using the NoteFactory
        }
    }
}
