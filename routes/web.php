<?php

use App\Mail\NovaSerie;
use Illuminate\Contracts\Queue\EntityResolver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/series', 'SeriesController@index')->name('listar_series');
Route::get('/series/criar', 'SeriesController@create')->name('form_criar_serie')->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')->middleware('autenticador');
Route::post('/series/{id}/editaNome', 'SeriesController@editaNome')->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')->middleware('autenticador');

Route::get('/series/{serieId}/temporadas', 'TemporadasController@index');

Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');

Route::post('/temporada/{temporada}/epsodios/assistir', 'EpisodiosController@assistir')->middleware('autenticador');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');

Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function(){
    Auth::logout();
    return redirect('/entrar');
});

Route::get('/visualizando-email', function(){
    return new NovaSerie(
        'Arrow',
        '5',
        '10'
    );
});

Route::get('/enviando-email', function(){
    $email = new NovaSerie(
        'Arrow',
        '5',
        '10'
    );
    $email->subject = 'Nova Série Adicionada';
    $user = (object)[
        'email' => 'priorigabriel22@gmail.com',
        'name' => 'Gabriel'
    ];
    Mail::to($user)->send($email);
    return 'Email enviado!';
});
