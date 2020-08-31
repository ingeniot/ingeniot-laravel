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

Route::get('/prueba', function () {
    return '<h2>Prueba de ruta</h2>';
});

Route::get('/dato/{dato}', function ($dato) {
    $texto='<h2>Dato recibido:</h2>';
    $texto.=$dato;
    return $texto;
});

Route::get('/vista/{dato?}', function ($dato) {
    $texto='<h2>Dato recibido:</h2>';
    $texto.=$dato;
    return view('vista',array(
        'texto'=>$texto
    ));
});

Route::get('/pruebas/prueba','PruebaControllers@index');

Route::get('/testorm','PruebaControllers@testOrm');