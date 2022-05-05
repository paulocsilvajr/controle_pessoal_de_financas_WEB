@extends('layout', ['css' => 'home'])

@section('cabecalho')
    @include('navegacao')
@endsection

@section('conteudo')
    <div class="container">
        <div class="row margem-navbar-conteudo mb-2">
            <div class="col-sm-6 col-md-9 titulo-conta-sm">
                <h1 class="text-center" style="margin: auto">{{ ucfirst($nomeConta) }}</h1>
            </div>
            <div class="col-sm-6 col-md-3 d-flex align-items-center">
            <button class="btn btn-primary btn-block" onclick="location.href = '/conta/{{ $nomeConta }}/cadastroLancamento';">
                    Novo Lançamento
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        @if($lancamentos == null)
            @php
                $mensagem = 'Sem lançamentos para a conta \'' . ucfirst($nomeConta) . '\'';
            @endphp
            @include('mensagem', ['mensagem' => $mensagem, 'tipo' => 'danger' ])
        @else
            <div class="table-responsive">

                <table class="table table-striped table-hover mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data</th>
                            <th scope="col">Número</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Conta</th>
                            <th scope="col">Débito</th>
                            <th scope="col">Crédito</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($lancamentos as $lancamento)
                            <tr>
                                <th scope="row" class="align-middle">{{ $lancamento->id }}</th>
                                <td class="align-middle">{{ App\Helpers\Formata::textoParaDataBrasilDT($lancamento->data) }}</td>
                                <td class="align-middle">{{ $lancamento->numero }}</td>
                                <td class="align-middle"><strong>{{ $lancamento->descricao }}</strong></td>
                                @if ($lancamento->nomeContaOrigem == $nomeConta)
                                    <td class="align-middle">{{ ucfirst($lancamento->nomeContaDestino) }}</td>
                                @else
                                    <td class="align-middle">{{ ucfirst($lancamento->nomeContaOrigem) }}</td>
                                @endif
                                <td class="alinhamento-numeros-tabela align-middle">{{ App\Helpers\Formata::valorParaMonetarioBrasil($lancamento->debito) }}</td>
                                <td class="alinhamento-numeros-tabela align-middle">{{ App\Helpers\Formata::valorParaMonetarioBrasil($lancamento->credito) }}</td>
                                <td class="text-center">
                                    <a href="/lancamentos/{{ $lancamento->id }}" class="btn btn-primary">Detalhes</a>
                                    <input name="" id="" class="btn btn-danger" type="button" value="Remover">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif

    </div>
@endsection

@section('script')
@endsection
