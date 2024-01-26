<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/category', [WelcomeController::class, 'changeCategory'])->name('welcome.category');
Route::post('/difficulty', [WelcomeController::class, 'changeDifficulty'])->name('welcome.difficulty');

Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
Route::get('/quiz/question/{question}', 
             [QuizController::class, 'showQuestion'])->name('quiz.show.question');
Route::post('/quiz/question/{question}',
             [QuizController::class, 'handleQuestionAnswer'])->name('quiz.handle.answer');
Route::get('/quiz/finish', [QuizController::class, 'finish'])->name('quiz.finish');

Route::get('/quiz/results', [QuizController::class, 'results'])->name('quiz.results');
Route::post('/quiz/results/filter', [QuizController::class, 'filterResults'])->name('quiz.results.filter');

Route::get('/error', [QuizController::class, 'error'])->name('error');