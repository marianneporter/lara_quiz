@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
    <div class="welcome-page min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen">
        <main class="main flex flex-col items-center justify-center max-w-[30rem]">
            <h1 class="text-5xl mb-4">Welcome to Lara Quiz!</h1>  
            <form method="post" action="{{ route('quiz.params') }}"
                  class="w-full flex flex-col items-center" >
                <div class = "text-white  w-full p-4 rounded-sm">
                    {{-- <div class="flex justify-center gap-2 flex-wrap">
                        @foreach ( config('custom.quiz.difficulties') as $difficulty)
                            <input type="radio" name="selected-answer"
                                id="answer_{{ $key }}" value="{{ $key }}" class="hidden" 
                                {{ $question->userAnswer == $key ? 'checked' : '' }} />             
                            <label class="border-2 border-orange-800  px-2">{{ $difficulty }}</label>                 
                        @endforeach
                    </div> --}}        
                </div>
                <div class = " text-white w-full p-4 rounded-sm">
                    <div class="flex justify-center gap-2 flex-wrap">
                        @foreach ( config('custom.quiz.categories') as $key => $category)
                            <input type="radio" name="selected-category"
                                   id="category_{{ $key }}" value="{{ $category }}" class="hidden"                                 
                                   {{ $key == $params->category ? 'checked' : '' }} />             
                            <label  class="border-2 border-orange-800  px-2">{{ $category }}</label>                         
                        @endforeach                       
                    </div>  
                </div>   
  
                <button type="submit" class="play-btn flex justify-center
                                             py-2 px-12 font-bold rounded mt-3">Play</button>
            </form>
        </main>
    </div> 
@endsection
