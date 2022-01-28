<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Serie;
use App\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemporadasController extends Controller
{
    public function index(int $serieId)
    {
        $serie = Serie::find($serieId);
        $temporadas = $serie->temporadas;

        if (Auth::check()) {
            $user = Auth::user()->name;
            return view('temporadas.index', compact('serie', 'temporadas', 'user'));
        }

        return view('temporadas.index', compact('serie', 'temporadas'));
    }


}
