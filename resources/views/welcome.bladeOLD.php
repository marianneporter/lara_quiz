@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="welcome-page min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
            <h1 class="text-5xl">Welcome to Lara Quiz!</h1>  
            
            <div  class="grid grid-cols-[auto,0.5rem,auto] grid-rows-2 gap-1 items-center" >
              
                    <span class="text-right">Current Category</span>
                    <span>:</span>
                    <span class="text-left">{{ $params->category }}</span>
              
                    <span class="text-right">Difficulty</span>
                    <span>:</span>
                    <span class="text-left">{{ $params->difficulty }}</span>
               
            </div> 

            <div class="flex flex-col ">
                <a href="{{ route('quiz.start') }}" class="border-2 border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white
                     font-bold py-2 px-4 rounded mt-3">Change Difficulty</a>
                <a href="{{ route('quiz.start') }}" class="border-2 border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white
                     font-bold py-2 px-4 rounded mt-3">Change Category</a>            
                <a href="{{ route('quiz.start') }}" class="play-btn flex justify-center py-2 font-bold  rounded mt-3">Play</a>
            </div>

        </main>
    </div> 
@endsection
