<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\NoteAttachment;
use Illuminate\Database\Seeder;

class NoteAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notes = Note::all();

        foreach ($notes as $note) {
            NoteAttachment::factory(2)->create(['note_id' => $note->id]); // Create 2 attachments for each note using the NoteAttachmentFactory
        }
    }
}
