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
    
    public function handleQuestionAnswer(Request $request, $questionNo) {

     
        $quizService = new QuizService();  

        $userAnswer = $request->input('selected-answer');
        $action     = $request->input('action');

        if ($userAnswer) {
            $quizService->updateUserAnswer($questionNo, $userAnswer);
        }       

        $questionNo = $action == 'next' ? $questionNo + 1 : $questionNo - 1;
                             
        return redirect()->route('quiz.question', ['question' => $questionNo]);
    }

    public function finish() {

        $quizService = new QuizService();  

        $score = $quizService->calcScore();

        return view('quiz.finish', ['score' => $score]);   
    }

}
