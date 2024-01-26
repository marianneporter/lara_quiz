@extends('layouts.app')

@section('title', 'Finish')

@section('content')
    <div class="min-w-full bg-blue-gradient text-white  min-h-screen">
        <main class="main flex flex-col items-center  p-2">
            <h1 class="text-2xl sm:text-3xl mb-3 mt-20">You scored {{ $score }} out of {{ $questionCount }}!</h1>
            <div class="flex flex-col w-full sm:w-[20rem] sm:flex-row  sm:gap-1">
                <a href="{{ route('quiz.results') }}"
                   class="play-btn px-8 py-3 rounded mt-3 font-bold
                          sm:flex-grow flex justify-center ">
                        See Answers</a>               
                        
                <a href="{{ route('welcome') }}" 
                   class="play-btn px-8 py-3 rounded mt-3
                          sm:flex-grow flex justify-center font-bold ">
                       Play Again
                </a>           
            </div>
        </main>
    </div> 
@endsection
