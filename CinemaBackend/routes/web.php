<?php

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::resource('films', FilmController::class)->names([
    'index' => 'films.index',
    'create' => 'films.create',
    'store' => 'films.store',
    'show' => 'films.show',
    'edit' => 'films.edit',
    'update' => 'films.update',
    'destroy' => 'films.destroy',
]);