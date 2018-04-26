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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'mobie/', 'middleware' => ['throttle']], function() { 

	Route::get('obtener/mensaje/bienvenida', 'ControladorPrueba@getMessage');
	Route::get('exportacion/json/movies', 'ImportMoviesJsonController@import');

	# Obtiene todas las Peliculas
	Route::get('get/movies', 'MoviesController@getMovies');

	# Catalogos
	# ===================================================================
	#  Paises
	Route::get('get/countries', 'CountriesController@getCountries');
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

	# ===================== FILTROS DE BUSQUEDA ========================
	# Busqueda por Titulo

	# Busqueda por Actores
	Route::get('actors/movies/{actorId?}', 'MoviesController@getMovieByActor');

	# Busqueda por Paises
	# Route::get('countries/movies/{countryId?}', 'MoviesController@getMovieByActor');
	
	# Busqueda por Año
	# Busqueda por Escritores
	# Busqueda por Generos
	# Actores que hayan participado en X Pelicula
	# Route::get('movies/actors/{movieId?}', 'MoviesController@getActorByMovies');
    # Route::resource('encrypImages', 'EncrypImages');


	# Nuevo Sistema
	Route::post('registrar/gasolina', 'GasolinaController@registrarGasolina');
	Route::get('get/kilometraje/{carId}', 'GasolinaController@getUltimoKilometrajeByCar');

	# Catalogs
    Route::get('get/categories', 'Catalogs@getCategories');
    Route::get('get/paymentmethods', 'Catalogs@getPaymentMethods');
    Route::get('get/paymentmethods/{type}', 'Catalogs@getPaymentMethodsByType');
    Route::get('get/banks', 'Catalogs@getBanks');
    Route::get('get/cars', 'Catalogs@getCars');
    
    # Save the Financial Log
    Route::post('store/financial/log', 'FinancialLog@saveFinancialLog');
});
