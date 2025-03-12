<?php

namespace App\Http\Controllers;

use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionAnswerController extends Controller
{
    public function index()
    {
        return Inertia::render('QuestionsAnswers/Index', [
            'questionsAnswers' => QuestionAnswer::all()
        ]);
    }
}
