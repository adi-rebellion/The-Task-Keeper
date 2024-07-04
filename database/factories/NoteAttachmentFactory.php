<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\NoteAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteAttachmentFactory extends Factory
{
    protected $model = NoteAttachment::class;

    public function definition()
    {
        return [
            'note_id' => Note::factory(),
            'file_path' => 'storage/app/public/' . $this->faker->word . '.' . $this->faker->fileExtension,
        ];
    }
}
