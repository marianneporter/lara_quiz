<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\AppState\Models\QuestionData;
use App\AppState\Models\QuizSession;
use Illuminate\Support\Facades\Session;

class QuizService
{

    public function fetchQuestions()
    {     
        $response = Http::get('https://opentdb.com/api.php?amount=10&difficulty=easy&type=multiple');
        $questions = $response->json();        
        $formattedQuestions = $this->formatDataForSession($questions["results"]);  
        $quizSession = new QuizSession();
        $quizSession->questions = $formattedQuestions;
        Session::put('quiz', $quizSession);   
    }

    public function getQuestion($questionNo) {
        $quizSession = session('quiz', []);     
        return $quizSession->questions[$questionNo];
    }

    public function calcScore() {
        $score = 0;
        $quizSession = session('quiz', []); 
        
        foreach ($quizSession->questions as $questionData) {
            if ($questionData->isCorrect()) {
                $score++;
            }
        }  
        
        $quizSession->score = $score;

        session(['quiz' => $quizSession]);
        
        return $score;
    }

    public function updateUserAnswer($questionNo, $userAnswer) {
        $quizSession = session('quiz', []);
        $quizSession->questions[$questionNo]->userAnswer = $userAnswer;
        session(['quiz' => $quizSession]);
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
                                     = html_entity_decode($possibleAnswersFromAPI[$j]);
            }

            $questionData->correctAnswer = array_search($questionsFromAPI[$i]["correct_answer"], 
                                                        $questionData->possibleAnswers);
                                                       
         
            // add question to formatted questions array 
            $formattedQuestions[$i+1] = $questionData;
        }

       
    
        return $formattedQuestions;
    }
}