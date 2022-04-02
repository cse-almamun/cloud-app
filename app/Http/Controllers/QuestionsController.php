<?php

namespace App\Http\Controllers;

use App\Models\Questions;

class QuestionsController extends Controller
{

    public function insertQuestion()
    {
        QuestionS::create([
            'question' => "What is your mother's maiden name?"
        ]);
    }
}
