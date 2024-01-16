<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuizService;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService) {
        $this->quizService = $quizService;        
    }

    public function start() {         
        session()->forget('quiz');
        $this->quizService->fetchQuestions();
        return redirect()->route('quiz.question', ['question' => 1]);
    }

    public function showQuestion($questionNo) {  
      
        $question = $this->quizService->getQuestion($questionNo);      
        return view('quiz.question', compact('question', 'questionNo'));    
    }
    
    public function handleQuestionAnswer(Request $request, $questionNo) {

        $userAnswer = $request->input('selected-answer');
        $action     = $request->input('action');

        if ($userAnswer) {
            $this->quizService->updateUserAnswer($questionNo, $userAnswer);
        }       

        $questionNo = $action == 'next' ? $questionNo + 1 : $questionNo - 1;
                             
        return redirect()->route('quiz.question', ['question' => $questionNo]);
    }

    public function finish() {  
        $score = $this->quizService->calcScore();
        return view('quiz.finish', ['score' => $score]);   
    }

    public function results() {
        $quizSession = $this->quizService->getQuizSession();
        return view('quiz.results', ['quiz' => $quizSession]);   
    }

}
