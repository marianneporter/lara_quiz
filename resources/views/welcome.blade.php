@extends('layouts.app')

@section('title', 'Welcome to Lara Quiz')

@section('content')
    <div class="welcome-page min-w-full bg-blue-gradient text-white flex items-center justify-center min-h-screen p-2">
        <main class="main flex flex-col items-center sm:justify-center max-w-[30rem]">
            <h1 class="text-5xl mb-4">Welcome to Lara Quiz!</h1>  
         
          
            <form method="post" action="{{ route('welcome.category') }}">
                @csrf
                <div class = " text-white w-full p-4 rounded-sm">
                    <div class="flex justify-center gap-2 flex-wrap">
                        @foreach ( $availableCategories as $categoryNo => $categoryName)                            
                            <button type="submit" name="category-no" 
                                class="rounded-sm  border-2 border-orange-700 px-2
                                        {{ $params->categoryNo == $categoryNo ? 
                                             'bg-orange-700' : ' bg-transparent' }}"
                                value="{{ $categoryNo  }}">{{ $categoryName }}                              
                            </button>                                  
                        @endforeach                       
                    </div>  
                </div>   
            </form>

                                                          
            <form method="post" action="{{ route('welcome.difficulty') }}">
                @csrf
                <div class = " text-white w-full p-4 rounded-sm">
                    <div class="flex justify-center gap-2 flex-wrap">
                        @foreach ( $availableDifficulties as $difficulty)                            
                            <button type="submit" name="difficulty" 
                                class="rounded-sm  border-2 border-orange-700 px-2
                                        {{ $params->difficulty == $difficulty ? 
                                             'bg-orange-700' : ' bg-transparent' }}"
                                value="{{ $difficulty  }}">{{ $difficulty }}                              
                            </button>                                  
                        @endforeach                       
                    </div>  
                </div>   
            </form>

            <a href="{{ route('quiz.start') }}" class="play-btn flex justify-center
                                         py-2 px-12 font-bold rounded mt-3">Play</a>
            

        </main>
    </div> 
@endsection
