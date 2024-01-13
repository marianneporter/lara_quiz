<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\AppState\Models\QuestionData;
use Illuminate\Support\Facades\Session;

class QuizService
{
    public function __construct()
    {
        if (!Session::has('quiz.questions')) {
            $this->fetchQuestions();
        }        
    }

    public function fetchQuestions()
    {      
        $response = Http::get('https://opentdb.com/api.php?amount=10&difficulty=easy&type=multiple');
        $questions = $response->json();      
        $formattedQuestions = $this->formatDataForSession($questions["results"]);
        Session::put('quiz.questions', $formattedQuestions);   
    }

    public function getQuestion($questionNo) {
        $questions = session('quiz.questions', []);
        $index = $questionNo--;
        return $questions[$index];
    }

    private function formatDataForSession($questionsFromAPI) {
        $formattedQuestions = [];
        for ($i=0; $i<=9; $i++)  {
            $questionData = new QuestionData();
            $questionData->questionNo = $i+1;
            $questionData->questionText = $questionsFromAPI[$i]["question"];
            $questionData->possibleAnswers = $questionsFromAPI[$i]["incorrect_answers"];
            array_push($questionData->possibleAnswers, $questionsFromAPI[$i]["correct_answer"]);
            shuffle($questionData->possibleAnswers);
            $questionData->correctAnswer = array_search($questionsFromAPI[$i]["correct_answer"], 
                                                        $questionData->possibleAnswers);
            array_push($formattedQuestions, $questionData);
        }
    
        return $formattedQuestions;
    }
}