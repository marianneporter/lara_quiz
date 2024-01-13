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

Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
Route::get('/quiz/question/{question}', [QuizController::class, 'showQuestion'])->name('quiz.question');
