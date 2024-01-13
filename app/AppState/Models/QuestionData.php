<?php

namespace App\AppState\Models;

class QuestionData {
   public int $questionNo;
   public string $questionText;
   public string $correctAnswer;
   public string $userAnswer = "";
   public array $possibleAnswers = [];    
}