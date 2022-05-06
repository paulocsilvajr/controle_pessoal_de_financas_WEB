<?php

namespace App\Models;

use App\Helpers\Formata;
use DateTime;

class Lancamento {

    public int $id;
    public string $cpfPessoa;
    public string $nomeContaOrigem;
    public DateTime $data;
    public string $numero;
    public string $descricao;
    public string $nomeContaDestino;
    public float $debito;
    public float $credito;
    public Datetime $dataCriacao;
    public Datetime $dataModificacao;
    public bool $estado;

    public function __construct($dados = null)
    {
        if (!is_null($dados)) {
            $this->fromJSON($dados);
        }
    }

    public function fromJSON($dados) {
        $this->id = $dados['id'];
        $this->cpfPessoa = $dados['cpf_pessoa'];
        $this->nomeContaOrigem = $dados['nome_conta_origem'];
        $this->data = Formata::textoParaDatetime($dados['data']);
        $this->numero = $dados['numero'];
        $this->descricao = $dados['descricao'];
        $this->nomeContaDestino = $dados['nome_conta_destino'];
        $this->debito = $dados['debito'];
        $this->credito = $dados['credito'];
        $this->dataCriacao = Formata::textoParaDatetime($dados['data_criacao']);
        $this->dataModificacao = Formata::textoParaDatetime($dados['data_modificacao']);
        $this->estado = $dados['estado'];
    }

    public function toJSONPost(): array {
        return array(
            "cpf_pessoa" => $this->cpfPessoa,
            "nome_conta_origem" => $this->nomeContaOrigem,
            "data" => Formata::DatetimeParaJson($this->dataCriacao),
            "numero" => $this->numero,
            "descricao" => $this->descricao,
            "nome_conta_destino" => $this->nomeContaDestino,
            "debito" => $this->debito,
            "credito" => $this->credito
        );
    }

    public function toJSON(): string {
        $json = $this->toJSONPost();
        return json_encode($json);
    }

    public function fromForm($request) {
        $this->cpfPessoa = $request->cpf_pessoa;
        $this->nomeContaOrigem = $request->nome_conta_origem;
        $data = $request->data;
        $this->numero = $request->numero;
        $this->descricao = $request->descricao;
        $this->nomeContaDestino = $request->nome_conta_destino;
        $valor = $request->valor;
        $tipo = $request->tipo;

        $this->dataCriacao = Formata::textoParaDatetimeForm($data);

        $this->debito = 0.0;
        $this->credito = 0.0;
        if ($tipo == 'debito') {
            $this->debito = floatval($valor);
        } else {
            $this->credito = floatval($valor);
        }
    }

    private function formataData(string $data): string {
        return "${data}T00:00:00Z";
    }
}
