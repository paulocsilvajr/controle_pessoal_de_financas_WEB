@extends('layout', ['css' => 'home'])

@section('cabecalho')
    @include('navegacao')
@endsection

@section('conteudo')
    <div class="container">
        <div class="row margem-navbar-conteudo mb-4">
            <div class="col">
                <h1 class="text-center" style="margin: auto">Cadastro de Lançamento em <u>{{ ucfirst($nomeConta) }}</u></h1>
            </div>
        </div>

        <form method="post" action="/conta/{{ $nomeConta }}/cadastroLancamento">
            @csrf

            <input type="hidden" id="id" name="id" value="{{ $id ?? '' }}">

            <input type="hidden" id="cpf_pessoa" name="cpf_pessoa" value="{{ $cpf ?? '' }}">

            <input type="hidden" id="nome_conta_origem" name="nome_conta_origem" value="{{ $nomeConta }}">

            <div class="row">
                <div class="col-sm mb-2">
                    <label for="data">Data</label>
                    <input type="date" id="data" name="data" class="form-control" placeholder="Data" value="{{ $data ?? '' }}" required autofocus />
                </div>
                <div class="col-sm mb-2">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero" class="form-control" placeholder="Número" value="{{ $numero ?? '' }}" required />
                </div>
            </div>

            <div class="row">
                <div class="col mb-2">
                    <label for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" placeholder="Descrição" value="{{ $descricao ?? '' }}" required />
                </div>
            </div>

            <div class="row">
                <div class="col mb-2">
                    <label for="nome_conta_destino">Conta</label>
                    <select name="nome_conta_destino" id="nome_conta_destino" class="form-control" required>
                        <option value=>Selecione uma conta</option>

                        @foreach ($contas as $nome => $nomeCompleto)
                            <option value="{{ $nome }}"
                            {{ ($destino == $nome) ? 'selected':'' }}
                            >{{ ucfirst($nomeCompleto) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm mb-2">
                    <label for="valor">Valor</label>
                    <input type="number" min=".01" step=".01" id="valor" name="valor" class="form-control" placeholder="Valor" value="{{ $valor ?? '' }}" required />
                </div>

                <div class="col-sm mb-2">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="debito"
                        {{ ($tipo == 'debito') ? "selected":'' }}
                        >Débito</option>
                        <option value="credito"
                        {{ ($tipo == 'credito') ? "selected":'' }}
                        >Crédito</option>
                    </select>
                </div>
            </div>

            @include('mensagem', ['mensagem' => $mensagem ?? '', 'tipo' => $tipoMensagem ])

            <div class="row mt-3">
                <div class="col-sm mb-2">
                    <button class="btn btn-primary btn-block" id="botao-salvar-lancamento" type="submit">
                        Salvar
                    </button>
                </div>
                <div class="col-sm mb-2">
                    <button class="btn btn-secondary btn-block" id="botao-voltar" onclick="history.back()">
                        Voltar
                    </button>
                </div>
            </div>


        </form>
    </div>
@endsection

@section('script')
@endsection
