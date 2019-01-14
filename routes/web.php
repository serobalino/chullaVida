<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::options('/home','JuegosController@index');
Route::post('/home','ParticipantesController@store');
Route::post('/chat','ChatController@enviarMsg');

Route::get('/play','GenerarReglasController@jugar')->name('play');

Route::get('regla','GenerarReglasController@generar');
Route::delete('regla','GenerarReglasController@parar');

Route::get('login/github', 'Auth\GithubController@redirectToProvider')->name('github');
Route::get('login/github/callback', 'Auth\GithubController@handleProviderCallback');

Route::get('login/google', 'Auth\GoogleController@redirectToProvider')->name('google');
Route::get('login/google/callback', 'Auth\GoogleController@handleProviderCallback');
