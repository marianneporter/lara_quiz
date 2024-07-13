<?php

namespace App\Http\Controllers;

use session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\QuizService;
use App\Services\QuizParamsService;
use Illuminate\Support\Facades\Log;

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
        
        //set up unique quiz id
        $quizId = Str::uuid()->toString();
        session()->put('quiz_id', $quizId);
        session()->put('quiz_status', 'inProgress');   

        if ($this->quizService->fetchQuestions()) {
            // questions fetched successfully
            return redirect()->route('quiz.show.question', ['quizId' => $quizId, 'question' => 1]);
        }    
        
        //error condition - api call unsuccessful
        return redirect()->route('error');
    }


    public function showQuestion($quizId, $questionNo) {          
        $question = $this->quizService->getQuestion($questionNo); 
        $params = $this->quizParamsService->getQuizParams();
        $questionCount = $params->noOfQuestions;    
        return view('quiz.question', 
                     compact('question', 'questionNo', 'questionCount', 'quizId'));    
    }
    
    public function handleQuestionAnswer(Request $request, $quizId, $questionNo) {
        
        $userAnswer = $request->input('selected-answer');      
     
        if ($userAnswer) {
            $this->quizService->updateUserAnswer($questionNo, $userAnswer);
        }  
        
        $action = $request->input('action');

        // go to finish after storing answer and finish button clicked
        if ($action == "finish") {
            return redirect()->route('quiz.finish', ['quizId' => $quizId]);
        }
        
        // go to next or previous question after storing current answer
        $questionNo = $action == 'next' ? $questionNo + 1 : $questionNo - 1;
                             
        return redirect()->route('quiz.show.question', [ 'quizId' => $quizId,
                                                         'question' => $questionNo]);
    }

    public function finish($quizId) {            
       
        $params = $this->quizParamsService->getQuizParams();
        $questionCount = $params->noOfQuestions; 
        $score = $this->quizService->calcScore();

        session()->put('quiz_status', 'completed');
     
        return view('quiz.finish', ['score' => $score,
                                    'questionCount' => $questionCount,
                                    'quizId' => $quizId ]);   
    }

    public function results($quizId) {
        $quizSession = $this->quizService->getQuizSession();
        $quizParams =$this->quizParamsService->getQuizParams();
        $filter = $quizParams->filterResults;
        $questionCount = $quizParams->noOfQuestions;
      
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
                                     'filter' => $quizParams->filterResults,
                                     'questionCount' => $questionCount,
                                     'quizId' => $quizId]);   
    }

    public function filterResults(Request $request, $quizId) {
     
        $filter = $request['filter'];       

        $this->quizParamsService->storeSelectedFilter($filter);

        return redirect()->route('quiz.results', $quizId);
       
    }

    public function error() {
        return view('error');
    }
}
