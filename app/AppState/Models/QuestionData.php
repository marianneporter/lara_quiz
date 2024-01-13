<?php

namespace App\AppState\Models;

class QuestionData {
   public int $questionNo;
   public string $questionText;
   public int $correctAnswer;
   public int $userAnswer;
   public array $possibleAnswers = [];    
}