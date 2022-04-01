<?php

namespace Database\Seeders;

use App\Models\Questions;
use Illuminate\Database\Seeder;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            ['question' => "In what city were you born?"],
            [
                'question' => "What is the name of your favorite pet?"
            ],
            [
                'question' => "What is your mother's maiden name?"
            ],
            [
                'question' => "What high school did you attend?"
            ],
            [
                'question' => "What is the name of your first school?"
            ],
            [
                'question' => "What was the make of your first car?"
            ],
            [
                'question' => "What was your favorite food as a child?"
            ],
            [
                'question' => "Where did you meet your spouse?"
            ],
        ];

        Questions::upsert($questions);
    }
}
