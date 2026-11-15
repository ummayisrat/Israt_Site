<?php

namespace Database\Seeders;

use App\Models\JournalEntry;
use Illuminate\Database\Seeder;

class JournalEntrySeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            [
                'title' => 'A quiet morning',
                'category' => 'Journal Entry',
                'body' => "There is something beautiful about an empty page waiting to be filled.\n\nA cup of coffee, a notebook, and a few minutes of silence can sometimes be enough.",
                'image_url' => 'https://images.unsplash.com/photo-1634746027343-985ad425b8b5?fm=jpg&q=80&w=1600',
                'entry_date' => '2026-10-01',
            ],
            [
                'title' => 'Things I never say',
                'category' => 'Reflection',
                'body' => "Some thoughts are easier to write than to speak.\n\nPerhaps that is why journals become such honest companions.",
                'image_url' => 'https://images.unsplash.com/photo-1456324504439-367cee3b3c32?auto=format&fit=crop&w=1600&q=85',
                'entry_date' => '2026-10-10',
            ],
            [
                'title' => 'Starting again',
                'category' => 'Creative Notes',
                'body' => "Starting over does not mean starting from nothing.\n\nWe carry every lesson, every mistake, and every little victory with us.",
                'image_url' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1600&q=85',
                'entry_date' => '2026-10-20',
            ],
        ];

        foreach ($entries as $entry) {
            JournalEntry::firstOrCreate(['title' => $entry['title']], $entry);
        }
    }
}
