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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'mobie/', 'middleware' => ['guest']], function() { 

	Route::get('obtener/mensaje/bienvenida', 'ControladorPrueba@getMessage');
	Route::get('exportacion/json/movies', 'ImportMoviesJsonController@import');
	Route::get('get/countries', 'CountriesController@getCountries');
	Route::get('get/movies', 'MoviesController@getMovies');

	# Directors
	Route::get('directors/get', 'Directors@getDirectors');

	# Actors
	Route::get('actors/get', 'Actors@getActors');
	
	# Writers
	Route::get('writers/get', 'Writers@getWriters');
	
	# Countries
	Route::get('countries/get', 'Countries@getCountries');

	# Genres
	Route::get('genres/get', 'Genres@getGenres');


});
