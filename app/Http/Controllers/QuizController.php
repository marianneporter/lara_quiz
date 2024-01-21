<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuizService;
use App\Services\QuizParamsService;

class QuizController extends Controller
{
    protected $quizService;
    protected $quizParamsService;

    public function __construct(QuizService $quizService,
                                QuizParamsService $quizParamsService) {
        $this->quizService = $quizService;   
        $this->quizParamsService = $quizParamsService;    
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
        $quizParams =$this->quizParamsService->getQuizParams();
        $filter = $quizParams->filterResults;
      
        $questionsToReturn = null;
        if ($filter == "All") {
            $questionsToReturn = $quizSession->questions;
        } else if ($filter == "Correct") {
            $questionsToReturn = array_filter($quizSession->questions, function($question) use ($filter) {
                return $question->isCorrect(); 
            });
        } else {
            $questionsToReturn = array_filter($quizSession->questions, function($question) use ($filter) {
                return !$question->isCorrect(); 
            });
        }



        return view('quiz.results', ['score'  => $quizSession->score,
                                     'questions'   => $questionsToReturn,
                                     'filter' => $quizParams->filterResults]);   
    }

    public function filterResults(Request $request) {
     
        $filter = $request['filter'];       

        $this->quizParamsService->storeSelectedFilter($filter);

        return redirect()->route('quiz.results');
       
    }

}
