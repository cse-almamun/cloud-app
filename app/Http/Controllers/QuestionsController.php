<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class QuestionsController extends Controller
{

    public function insertQuestion()
    {
        QuestionS::create([
            'question' => "What is your mother's maiden name?"
        ]);
    }
}
