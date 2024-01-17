<?php
namespace App\Services;

use App\AppState\Models\QuizParams;

class QuizParamsService
{
    public function initialiseSessionParams() {
        $quizParams = new QuizParams();
        $quizParams->category = config('custom.quiz.default_category');
        $quizParams->difficulty = config('custom.quiz.default_difficulty');

        session(['quiz' => $quizParams]);

        return $quizParams;
    }

    public function storeDefaultParams() {

    }

    public function storeSelectedCategory() {

    }

    public function storeSelectedDifficulty() {

    }

    

}