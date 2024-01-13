@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="container bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
            <h1 class="text-4xl">Welcome to Lara Quiz!</h1>
            <!-- Your page content goes here -->
            <a href="{{ route('quiz.start') }}" class="text-white bg-orange-500 hover:bg-orange-600
                           font-bold py-2 px-8 rounded mt-3">Play</a>
        </main>
    </div> 
@endsection
