<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {return view('welcome');});
Route::get('/fetch_challengers', 'FetchController@fetchChallengers');
Route::get('/fetch_masters', 'FetchController@fetchMasters');
Route::get('/fetch_match', function () {return view('fetch_match');});

Route::post('/ajax/fetch_match_call', 'FetchController@fetchMatches');
