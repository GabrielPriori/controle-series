@extends('layout')

@section('cabecalho')
    Séries
@endsection

@section('conteudo')

    @include('mensagem', ['mensagem' => $mensagem])

    @auth
        <a href="{{ route('form_criar_serie') }}" class="btn btn-dark mb-2">Adicionar</a>
    @endauth

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-items-center">

                <div>
                    <img src="{{$serie->capa_url}}" class="img-thumbnail" height="100px" width="100px">
                    <a href="/series/{{ $serie->id }}/temporadas" id="nome-serie-{{ $serie->id }}">{{ $serie->nome }}</a>
                </div>

                <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->id }}">
                    <input type="text" class="form-control" value="{{ $serie->nome }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="editarSerie({{ $serie->id }})">
                            Gravar
                        </button>
                        @csrf
                    </div>
                </div>

                <span class="d-flex">
                    <a href="/series/{{ $serie->id }}/temporadas" class="btn btn-info btn-sm mr-1">Ver</a>

                    @auth
                        <button class="btn btn-info btn-sm mr-1" onclick="toggleInput({{ $serie->id }})">
                            Editar
                        </button>
                    @endauth

                    @auth
                        <form method="post" action="/series/{{ $serie->id }}"
                            onsubmit="return confirm('Tem certeza que deseja remover {{ addslashes($serie->nome) }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Excluir
                            </button>
                        </form>
                    @endauth

                </span>
            </li>
        @endforeach
    </ul>
    <script>
        function toggleInput(serieId) {
            const nomeSerieEl = document.getElementById(`nome-serie-${serieId}`);
            const inputSerieEl = document.getElementById(`input-nome-serie-${serieId}`);

            if (nomeSerieEl.hasAttribute('hidden')) {
                nomeSerieEl.removeAttribute('hidden');
                inputSerieEl.hidden = true;
            } else {
                inputSerieEl.removeAttribute('hidden');
                nomeSerieEl.hidden = true;
            }
        }

        function editarSerie(serieId) {
            let formData = new FormData();
            const nome = document.querySelector(`#input-nome-serie-${serieId} > input`).value;
            token = document.querySelector('input[name="_token"]').value;

            formData.append('nome', nome);
            formData.append('_token', token);

            const url = `/series/${serieId}/editaNome`;
            fetch(url, {
                body: formData,
                method: 'POST'
            }).then(() => {
                toggleInput(serieId);
                document.getElementById(`nome-serie-${serieId}`).textContent = nome;
            });
        }
    </script>
@endsection
