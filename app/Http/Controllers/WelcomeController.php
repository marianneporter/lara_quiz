<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuizParamsService;

class WelcomeController extends Controller
{
    protected $quizParamsService;

    public function __construct(QuizParamsService $quizParamsService) {
        $this->quizParamsService = $quizParamsService;       
    }

    public function index() {  
        
        if ($this->quizParamsService->quizParamsSet()) {
            $quizParams = $this->quizParamsService->getQuizParams(); 
        } else {
            $quizParams = $this->quizParamsService->initialiseSessionParams(); 
        }           
         
        $availableCategories   =  config('custom.quiz.categories');   
        $availableDifficulties =  config('custom.quiz.difficulties');  
      
        return view('welcome', [
            'params' => $quizParams,
            'availableCategories' => $availableCategories,
            'availableDifficulties' => $availableDifficulties
        ]);
    }

    public function changeCategory(Request $request) {

        $newCategory = $request['category'];

        $this->quizParamsService->storeSelectedCategory($newCategory);
       
        return redirect()->route('welcome');
    }

    public function changeDifficulty(Request $request) {

        $newDifficulty = $request['difficulty'];

        $this->quizParamsService->storeSelectedDifficulty($newDifficulty);
       
        return redirect()->route('welcome');
    }
    
}