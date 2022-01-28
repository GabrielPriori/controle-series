<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Serie;
use App\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpisodiosController extends Controller
{
    public function index(Temporada $temporada, Request $request)
    {
        $serie = Serie::find($temporada);

        if (Auth::check()) {
            return view('episodios.index', [
                'episodios' => $temporada->episodios,
                'temporadaId' => $temporada->id,
                'temporadaNumero' => $temporada->numero,
                'mensagem' => $request->session()->get('mensagem'),
                'user' => Auth::user()->name,
                'serie' => $serie
            ]);
        }

        return view('episodios.index', [
            'episodios' => $temporada->episodios,
            'temporadaId' => $temporada->id,
            'temporadaNumero' => $temporada->numero,
            'mensagem' => $request->session()->get('mensagem')
        ]);
    }

    public function assistir(Temporada $temporada, Request $request)
    {
        $episodiosAssistidos = $request->episodios;
        $temporada->episodios->each(function (Episodio $episodio) use ($episodiosAssistidos) {
            $episodio->assistido = in_array($episodio->id, $episodiosAssistidos);
        });
        $temporada->push();
        $request->session()->flash('mensagem', 'Episódios marcados como assistidos');

        return redirect()->back();
    }
}
