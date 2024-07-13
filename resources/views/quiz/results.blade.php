@php
    $allFilterClass = $filter == 'All' ? "bg-orange-700" : "bg-transparent";
    $incorrectFilterClass = $filter == 'Incorrect' ? "bg-orange-700" : "bg-transparent";
    $correctFilterClass = $filter == 'Correct' ? "bg-orange-700" : "bg-transparent";

    $allElDisabled = $filter == 'All' ? "disabled" : "";
    $incorrectElDisabled = $filter == 'Incorrect' ? "disabled" : "";
    $correctElDisabled = $filter == 'Correct' ? "disabled" : "";
@endphp

@extends('layouts.app')

@section('title', 'Results')

@section('content')
    <div class="min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen p-2">
        <main class="main flex flex-col items-center justify-center">
            <div class="flex flex-col sm:flex-row justify-between w-full sm:w-[30rem]">
                <h1 class="text-3xl mt-4 sm:mt-16 mb-3 order-2 sm:order-1">You scored {{ $score }} out of {{ $questionCount }}!</h1>
                <div class="pt-2 mt-8 sm:mt-16  order-1 sm:order2 ml-auto">
                    <a href="{{ route('welcome') }}" class="play-btn flex justify-center
                                                            py-2 px-8 font-bold rounded  ">
                        Play Again
                    </a>  
                </div> 
            </div>
        
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2 mt-2 sm:mt-4">
                <h2 class="text-2xl">Your Results</h2>                   
                <form action="{{ route('quiz.results.filter', ['quizId' => $quizId ]) }}" method="post" >
                    @csrf
                    <div class="flex gap-2">
                        <button type="submit" name="filter" 
                            class="rounded-sm border-2 border-orange-700 px-2
                              bg-orange-700  {{ $allFilterClass }} "                
                              value="All" {{ $allElDisabled }}>See All                             
                        </button> 
                        <button type="submit" name="filter" 
                            class="rounded-sm  border-2 border-orange-700 px-2
                                bg-orange-700 {{ $incorrectFilterClass }}"                      
                                value="Incorrect" {{ $incorrectElDisabled }}  >Incorrect Only                             
                        </button>    
                        <button type="submit" name="filter" 
                            class="rounded-sm  border-2 border-orange-700 px-2
                                bg-orange-700 {{ $correctFilterClass }}"                       
                                    value="Correct" {{ $correctElDisabled }} >Correct Only                             
                        </button>           
                    </div>              
                </form>
                               
            </div>
           

            @foreach ($questions as $question) 
                <div class="bg-white rounded-lg py-3 px-4 shadow-md w-full sm:w-[30rem]
                            hover:bg-orange-200 text-black mt-4 mb-4">
                    <p>Question {{ $question->questionNo }}</p>
                    <p class="mt-2 break-words">{{ $question->questionText }}</p>
                    <hr class="border border-blue-900 mt-4 mb-2"/>
                    <div class="flex items-center justify-between">                        
                        <div>
                            <p>Your Answer:
                                {{ $question->userAnswer ?
                                   $question->possibleAnswers[$question->userAnswer] : "" }}
                            </p>
                            @if (!($question->userAnswer == $question->correctAnswer))      
                                <p class="mt-2">Correct Answer:
                                    {{ $question->possibleAnswers[$question->correctAnswer] }}
                                </p>
                            @endif
                        </div>
                        <div>
                            @if ($question->correctAnswer == $question->userAnswer)
                               <i class="fa-solid fa-check fa-2x text-green-700"></i>
                            @else
                               <i class="fa-solid fa-xmark fa-2x text-red-700"></i>
                            @endif
                        </div>
                    </div> 
                </div>  
            @endforeach 
            <div class="pt-2 mt-4 mb-10">
                <a href="{{ route('welcome') }}" class="play-btn flex justify-center
                                                        py-2 px-12 font-bold rounded mt-3">
                    Play Again
                </a>  
            </div> 
        </main>
    </div> 
@endsection
