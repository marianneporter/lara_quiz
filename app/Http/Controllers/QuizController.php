<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuizService;

class QuizController extends Controller
{
    public function start() {   
       
        session()->forget('quiz.questions');

        return redirect()->route('quiz.question', ['question' => 1]);
    }

    public function showQuestion($questionNo) {
        $quizService = new QuizService();
        $question = $quizService->getQuestion($questionNo);      
        return view('quiz.question', compact('question', 'questionNo'));    
    }

}
