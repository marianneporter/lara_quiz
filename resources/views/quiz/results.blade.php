@extends('layouts.app')

@section('title', 'Results')

@section('content')
    <div class="min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
            <div class="flex justify-between w-[30rem]">
                <h1 class="text-3xl mt-4 mb-3 ">You scored {{ $quiz->score }} out of 10!</h1>
                <div class="pt-2 mt-4">
                    <a href="{{ route('welcome') }}" class="text-white bg-orange-500 hover:bg-orange-600
                                                            font-bold py-2 px-6 rounded mt-3">
                        Play Again
                    </a>  
                </div> 
            </div>
        
            <h2 class="text-2xl mt-2">Your Results</h2>

            @foreach ($quiz->questions as $questions) 
                <div class="bg-white rounded-lg py-3 px-4 shadow-md w-[30rem]
                            hover:bg-orange-200 text-black mt-4 mb-4">
                    <p>Question {{ $questions->questionNo }}</p>
                    <p class="mt-2">{{ $questions->questionText }}</p>
                    <hr class="border border-blue-900 mt-4 mb-2"/>
                    <div class="flex items-center justify-between">                        
                        <div>
                            <p>Your Answer:
                                {{ $questions->userAnswer ?
                                   $questions->possibleAnswers[$questions->userAnswer] : "" }}
                            </p>
                            @if (!($questions->userAnswer == $questions->correctAnswer))      
                                <p class="mt-2">Correct Answer:
                                    {{ $questions->possibleAnswers[$questions->correctAnswer] }}
                                </p>
                            @endif
                        </div>
                        <div>
                            @if ($questions->correctAnswer == $questions->userAnswer)
                               <i class="fa-solid fa-check fa-2x text-green-700"></i>
                            @else
                               <i class="fa-solid fa-xmark fa-2x text-red-700"></i>
                            @endif
                        </div>
                    </div> 
                </div>  
            @endforeach 
            <div class="pt-2 mt-4 mb-10">
                <a href="{{ route('welcome') }}" class="text-white bg-orange-500 hover:bg-orange-600
                                                        font-bold py-2 px-6 rounded mt-3">
                    Play Again
                </a>  
            </div> 
        </main>
    </div> 
@endsection
