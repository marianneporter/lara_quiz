

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
              
                <div class="possible-answer bg-white rounded-lg py-3 px-4 shadow-md w-[30rem]
                            hover:bg-orange-200 text-black mt-3">
                    <span class="text-xl answer-key" >{{$key}}</span>
                    {{ $value }}
                </div>                      
            @endforeach

            <div>
                <form action="{{ route('quiz.question', $questionNo) }}" method="post">
                    @csrf                  
                    <input id="selected-answer" type="hidden" name="selected-answer" value="">                   
                    <button type="submit" name="action" value="previous" class="p-3">Previous</button>
                    <button type="submit" name="action" value="next" class="p-3">Next</button>
                </form>  
            </div>          
        </main>
    </div> 

    <script>
        console.log('welcome to javascript');
        const selectedAnswer = document.getElementById('selected-answer');
        const possibleAnswers = document.querySelectorAll('.possible-answer');
        console.log(possibleAnswers);
        possibleAnswers.forEach( possibleAnswer => {
            possibleAnswer.addEventListener('click', () => {
                let userAnswer = possibleAnswer.querySelector('.answer-key').textContent;
                // set hidden form value
                selectedAnswer.value = userAnswer;
                console.log(userAnswer);
            })
        })
    </script>

@endsection
