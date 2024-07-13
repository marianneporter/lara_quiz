<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckQuizIntegrity
{
    /**
     * Handle an incoming request.
     * 
     * Keeps integrity for the quiz in process
     * 
     * Guarantees 1. the user cannot directly route back to a quiz other than the current one
     *            2. the user cannot go back to the questions for the current quiz
     *               once they have arrived at the the finish or results page
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $routeName = $route->getName();
    
        $sessionQuizId = session()->get('quiz_id');
        $sessionQuizStatus = session()->get('quiz_status');      

        $quizIdFromRoute = $request->route('quizId'); 

        // invalid condition
        if (!$sessionQuizId || !$sessionQuizStatus) {         
            return redirect()->route('welcome');
        }

        // prevent user from attempting to get back to a previous quiz
        if ( $quizIdFromRoute !== $sessionQuizId ) {
            return redirect()->route('welcome');
        }

        //prevent user from going back to questions once in results mode
        if ($sessionQuizStatus === 'completed'
                 && $routeName === 'quiz.show.question') {
            Log::info('******************results mode - blocked from going back to questions');
            Log::info('navigating to ' . $routeName);
            return redirect()->route('quiz.finish', ['quizId' => $quizIdFromRoute]);
        }        
        return $next($request);
    }
}
