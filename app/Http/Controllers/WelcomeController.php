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
         
        $availableCategories =  config('custom.quiz.categories');   
        return view('welcome', [
            'params' => $quizParams,
            'availableCategories' => $availableCategories
        ]);
    }

    public function changeCategory(Request $request) {

        $newCategoryNo = $request['category-no'];

        $this->quizParamsService->storeSelectedCategory($newCategoryNo);
       
        return redirect()->route('welcome');
    }

    
}