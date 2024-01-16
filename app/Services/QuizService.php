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

    public function getQuizSession() {
        return session('quiz', []);
    }

    /**
     *   Formatting of API data ready for storing in session.
     *   The formatting of each array element if the Quiz
     *   The entire quiz is based on this
     */
    private function formatDataForSession($questionsFromAPI) {
        $formattedQuestions = [];
        //iterate through api questions and format into the QuestionData class format
        //use 0-9 index for the api question#.  add 1 to get the quiz question# for session
        for ($i=0; $i<=9; $i++)  {
            $questionData = new QuestionData();
            $questionData->questionNo = $i + 1;
            $questionData->questionText = html_entity_decode($questionsFromAPI[$i]["question"]);

            // store correct and incorrect answers from API in temporary 
            // $possibleAnswersFromAPI array           
            $possibleAnswersFromAPI =  $questionsFromAPI[$i]["incorrect_answers"];
            array_push($possibleAnswersFromAPI, $questionsFromAPI[$i]["correct_answer"] );
            shuffle($possibleAnswersFromAPI);
           
                                          
            // Each possible answer assigned letters A-D for quiz
            $answerLetters = range('A', 'D');

            // loop through all possible answers. Store in associative array under keys A-D ready 
            // for display in quiz. 
            for ($j=0; $j<4; $j++) {
                
                // check where the correct answer is in possible answers array after shuffle.
                // Store the letter for the correct answer in the QuestionData->correctAnswer
                // as this is what will be compared later with the answer the user chooses.
                if ( $possibleAnswersFromAPI[$j] ==  $questionsFromAPI[$i]["correct_answer"] ) {
                    $questionData->correctAnswer = $answerLetters[$j];
                }

                // Store all possible answers in QuestionData object with their letters ready for display in quiz
                $questionData->possibleAnswers[$answerLetters[$j]] 
                                        = html_entity_decode($possibleAnswersFromAPI[$j]);
            }                                                       
         
            // add question to formatted questions array 
            $formattedQuestions[$i+1] = $questionData;
        }       
       
        return $formattedQuestions;
    }
}