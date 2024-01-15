@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center">
            <h1 class="text-3xl mb-3">You scored {{ $score }} out of 10!</h1>
            <div class="flex justify-between w-[20rem]">
                <a class="text-white bg-orange-500 hover:bg-orange-600
                        font-bold py-2 px-8 rounded mt-3">
                        See Answers</a>               
                        
                <a class="text-white bg-orange-500 hover:bg-orange-600
                       font-bold py-2 px-6 rounded mt-3">
                       Play Again</a>           
            </div>
        </main>
    </div> 
@endsection
