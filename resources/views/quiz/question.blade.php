@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="question-page min-w-full bg-blue-gradient text-white
                flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
           
            <h1 class="text-xl">Question {{$questionNo}} </h1>
          
            <div class="bg-white rounded-lg py-3 px-4 shadow-md w-[30rem]
                        hover:bg-orange-200 text-black mt-4 mb-4">
                <span class="text-xl" >Q </span>
                {{ $question->questionText }}
            </div>   

            <h1 class="text-xl">Select Answer...</h1>

            <form action="{{ route('quiz.question', $questionNo) }}" method="post">
                @csrf

                @foreach ($question->possibleAnswers as $key => $value)
                    <div class="mb-3">
                        <input type="radio" name="selected-answer"
                               id="answer_{{ $key }}" value="{{ $key }}" class="hidden" 
                               {{ $question->userAnswer == $key ? 'checked' : '' }} />
                        <label for="answer_{{ $key }}"
                               class="block bg-white cursor-pointer rounded-lg py-3 px-4 
                                      shadow-md w-[30rem] hover:bg-orange-200 text-black">
                            <span class="text-xl">{{ $key }}. </span>{{ $value }}
                        </label>
                    </div>
                @endforeach

                <div class="flex justify-between">
                    @if ($questionNo != 1) 
                        <button type="submit" name="action" value="previous" class="p-3">
                            <i class="fa-solid fa-backward"></i> Previous</button>
                    @endif
                   
                    @if ($questionNo < 10)                     
                       <button type="submit" name="action" value="next" class="p-3 ml-auto">
                            Next <i class="fa-solid fa-forward"></i></button>
                    @else
                        <a href="{{ route('quiz.start') }}"
                           class="text-white bg-orange-500 hover:bg-orange-600
                                    font-bold py-2 px-8 rounded mt-3">Finish</a>
                    @endif
                </div>
            </form>

@endsection
