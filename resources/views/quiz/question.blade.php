

@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="container bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
           
            <h1>Question {{$questionNo}} </h1>
          
            <div class="bg-white rounded-lg p-4 shadow-md
                        hover:bg-orange-200 text-black">
                {{ $question["question"] }}
            </div>           
        </main>
    </div> 
@endsection
