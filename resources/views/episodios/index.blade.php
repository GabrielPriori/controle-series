@extends('layout')

@section('cabecalho')
Episódios da {{$temporadaNumero}}° Temporada
@endsection

@section('conteudo')
    @include('mensagem', ['mensagem' => $mensagem])
    <form action="/temporada/{{$temporadaId}}/epsodios/assistir" method="POST">
        @csrf
        <ul class="list-group">
            @foreach($episodios as $episodio)
            <li class="list-group-item d-flex justify-content-between">
                Episódio {{ $episodio->numero }}
                <div>
                    <input class="form-check-input" name="episodios[]" type="checkbox" value="{{$episodio->id}}"
                    {{ $episodio->assistido ? 'checked' : '' }} >
                </div>
            </li>
            @endforeach
        </ul>
        @auth
        <button class="btn btn-primary mt-2 mb-2">Salvar</button>
        @endauth
    </form>
@endsection
