<?php

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


Route::get('/', \App\Livewire\Patient::class);
Route::get('/home', \App\Livewire\Patient::class);
Route::get('patient', \App\Livewire\Patient::class);
Route::get('analysis', \App\Livewire\Analysis::class);
Route::get('category', \App\Livewire\Category::class);
Route::get('insurance', \App\Livewire\Insurance::class);

Auth::routes();

