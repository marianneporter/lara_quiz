<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\AppState\Models\QuizSession;
use Illuminate\Support\Facades\Http;
use App\AppState\Models\QuestionData;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\ConnectionException;


class QuizService
{
    protected $quizParamsService;

    public function __construct(QuizParamsService $quizParamsService) {
        $this->quizParamsService = $quizParamsService;
    }

    public function fetchQuestions()
    {    
        $quizParams = $this->quizParamsService->getQuizParams();
      
        $questionCount = $quizParams->noOfQuestions;
        $difficulty = strtolower($quizParams->difficulty);

        $queryString = "limit=$questionCount&categories=$quizParams->category&difficulty=$difficulty&region=GB";

        $quizUrl = "https://the-trivia-api.com/v2/questions?{$queryString}";

        try {
            $response = Http::timeout(5)->get($quizUrl); // Set timeout to 5 seconds           
            $questions = $response->json();             
        } catch (ConnectionException $e) {
            Log::error('****** API connection failed *******', [
                'url' => $quizUrl,
                'exception' => $e->getMessage()
            ]);
            return false;
        }
  
        if (!$questions) {            
            return false;
        }
          
        $formattedQuestions = $this->formatDataForSession($questions);  
        $quizSession = new QuizSession();
        $quizSession->questions = $formattedQuestions;
        Session::put('quiz', $quizSession);  
        return true; 
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
        $quizParams=$this->quizParamsService->getQuizParams();
        $questionCount = $quizParams->noOfQuestions;
        //iterate through api questions and format into the QuestionData class format
        //use 0-9 index for the api question#.  add 1 to get the quiz question# for session
        for ($i=0; $i <= $questionCount - 1; $i++)  {
            $questionData = new QuestionData();
            $questionData->questionNo = $i + 1;       
            $questionData->questionText = $questionsFromAPI[$i]["question"]['text'];

            // store correct and incorrect answers from API in temporary 
            // $possibleAnswersFromAPI array           
            $possibleAnswersFromAPI =  $questionsFromAPI[$i]["incorrectAnswers"];
            array_push($possibleAnswersFromAPI, $questionsFromAPI[$i]["correctAnswer"] );
            shuffle($possibleAnswersFromAPI);
           
                                          
            // Each possible answer assigned letters A-D for quiz
            $answerLetters = range('A', 'D');

            // loop through all possible answers. Store in associative array under keys A-D ready 
            // for display in quiz. 
            for ($j=0; $j<4; $j++) {
                
                // check where the correct answer is in possible answers array after shuffle.
                // Store the letter for the correct answer in the QuestionData->correctAnswer
                // as this is what will be compared later with the answer the user chooses.
                if ( $possibleAnswersFromAPI[$j] ==  $questionsFromAPI[$i]["correctAnswer"] ) {
                    $questionData->correctAnswer = $answerLetters[$j];
                }

                // Store all possible answers in QuestionData object with their letters ready for display in quiz
                $questionData->possibleAnswers[$answerLetters[$j]] = $possibleAnswersFromAPI[$j];
            }                                                       
         
            // add question to formatted questions array 
            $formattedQuestions[$i+1] = $questionData;
        }       

        return $formattedQuestions;
    }
}