

@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
           
            <h1 class="text-xl">Question {{$questionNo}} </h1>
          
            <div class="bg-white rounded-lg py-3 px-4 shadow-md w-[30rem]
                        hover:bg-orange-200 text-black mt-4 mb-4">
                <span class="text-xl" >Q </span>
                {{ $question->questionText }}
            </div>   

            <h1 class="text-xl">Select Answer...</h1>

            @foreach ($question->possibleAnswers as $key => $value)
              
                <div class="bg-white rounded-lg py-3 px-4 shadow-md w-[30rem]
                            hover:bg-orange-200 text-black mt-3">
                    <span class="text-xl" >{{$key}}</span>
                    {{ $value }}
                </div>                      
            @endforeach

            <div>

            </div>
          
        </main>
    </div> 
@endsection
