<?php

namespace App\Http\Controllers;

use App\Services\QuizParamsService;

class WelcomeController extends Controller
{
    protected $quizParamsService;

    public function __construct(QuizParamsService $quizParamsService) {
        $this->quizParamsService = $quizParamsService;       
    }

    public function index() {         
        $quizParams = $this->quizParamsService->initialiseSessionParams();       
        return view('welcome', ['params' => $quizParams]);
    }
}