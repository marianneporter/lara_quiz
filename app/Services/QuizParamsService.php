<?php
namespace App\Services;

use App\AppState\Models\QuizParams;

class QuizParamsService
{
    public function initialiseSessionParams() {
        $quizParams = new QuizParams();
        $quizParams->categoryNo = config('custom.quiz.default_category');
        $quizParams->difficulty = config('custom.quiz.default_difficulty');
        $quizParams->filterResults = "All";

        session(['quizParams' => $quizParams]);

        return $quizParams;
    }

    public function quizParamsSet() {
        return session()->has('quizParams');
    }

    public function getQuizParams() {
        return session('quizParams');
    }

    public function storeSelectedCategory($newCategoryNo) {
      
        $quizParams = session('quizParams');
        $quizParams->categoryNo = $newCategoryNo;
        session(['quizParams' => $quizParams]);  
        return $quizParams;      
    }

    public function storeSelectedDifficulty($difficulty) {
        $quizParams = session('quizParams');
        $quizParams->difficulty = $difficulty;
        session(['quizParams' => $quizParams]);  
        return $quizParams;      
    }

    public function storeSelectedFilter($newFilter) {
        $quizParams = session('quizParams');
        $quizParams->filterResults = $newFilter;
        session(['quizParams' => $quizParams]);  
        return $quizParams;     
    }

    

}