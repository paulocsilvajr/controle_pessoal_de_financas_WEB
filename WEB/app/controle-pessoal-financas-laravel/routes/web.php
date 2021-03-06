<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/login', 'EntrarController@index')->name('login');
Route::post('/login', 'EntrarController@entrar');
Route::get('/logout', 'EntrarController@sair')->name('logout');

Route::get('/', 'PrincipalController@index')
    ->middleware('autenticador');
Route::get('/home', 'PrincipalController@index')->name('home')
    ->middleware('autenticador');

Route::get('/api', 'RotasApiController@index')
    ->middleware('autenticador');

Route::get('/conta', 'ContaController@index')->name('conta')
    ->middleware('autenticador');
Route::get('/conta/{nomeConta}', 'ContaController@contaEspecifica')->name('contaEspecifica')
    ->middleware('autenticador');
Route::get('/conta/{nomeConta}/cadastroLancamento', 'ContaController@carregaCadastroLancamento')->name('contaCadastroLancamento')
    ->middleware('autenticador');
Route::post('/conta/{nomeConta}/cadastroLancamento', 'ContaController@cadastraLancamento')
    ->middleware('autenticador');

Route::get('/lancamentos/{idLancamento}', 'ContaController@carregaLancamento')
    ->middleware('autenticador');
