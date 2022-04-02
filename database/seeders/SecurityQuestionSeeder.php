<?php

namespace Database\Seeders;

use App\Models\Questions;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'In what city were you born?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What is the name of your favorite pet?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What is your mother's maiden name?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What high school did you attend?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What is the name of your first school?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What was the make of your first car?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "What was your favorite food as a child?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => "Where did you meet your spouse?",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Questions::insert($questions);
    }
}
