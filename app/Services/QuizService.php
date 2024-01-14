<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\AppState\Models\QuestionData;
use App\AppState\Models\PossibleAnswer;
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
        return $questions[$questionNo];
    }

    public function updateUserAnswer($questionNo, $userAnswer) {
        $questions = session('quiz.questions', []);
        $questions[$questionNo]->userAnswer = $userAnswer;
    }

    private function formatDataForSession($questionsFromAPI) {
        $formattedQuestions = [];
        //iterate through api questions and format into the QuestionData class format
        //use 0-9 index for the api question#.  add 1 to get the quiz question# for session
        for ($i=0; $i<=9; $i++)  {
            $questionData = new QuestionData();
            $questionData->questionNo = $i + 1;
            $questionData->questionText = html_entity_decode($questionsFromAPI[$i]["question"]);

            $possibleAnswersFromAPI =  $questionsFromAPI[$i]["incorrect_answers"];
            array_push($possibleAnswersFromAPI, $questionsFromAPI[$i]["correct_answer"] );
            shuffle($possibleAnswersFromAPI);
           
            $answerLetters = range('A', 'D');
            for ($j=0; $j<4; $j++) {
                $questionData->possibleAnswers[$answerLetters[$j]] 
                                     = $possibleAnswersFromAPI[$j];
            }

            $questionData->correctAnswer = array_search($questionsFromAPI[$i]["correct_answer"], 
                                                        $questionData->possibleAnswers);
                                                       
          //  array_push($formattedQuestions, $questionData);
            // add question to formatted questions array using indices 1-10
            $formattedQuestions[$i+1] = $questionData;
        }

       
    
        return $formattedQuestions;
    }
}