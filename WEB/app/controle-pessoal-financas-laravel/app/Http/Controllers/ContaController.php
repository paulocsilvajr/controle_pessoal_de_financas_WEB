<?php

namespace App\Http\Controllers;

use App\Helpers\Cria;
use App\Helpers\Imprime;
use App\Helpers\LogPersonalizado;
use App\Models\Conta;
use App\Models\Lancamento;
use App\Services\RequisicaoHttp;
use App\Services\Token;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    public function index(Request $request, RequisicaoHttp $http, Token $token)
    {
        $resposta = $http->get('/contas');

        if ($resposta->successful()) {
            $dados = $resposta['data'];

            $arrayContas = Cria::arrayContas($dados);

            $arrayNomesCompletos = $this->geraArrayContasCompleto($dados);

            $request->session()->put('contas', $arrayNomesCompletos);

            return view(
                'Conta.conta',
                compact(
                    'arrayContas',
                )
            );
        }

        return redirect()->route('home');
    }

    public function listaLancamentosConta(Request $request, RequisicaoHttp $http, Token $token, string $nomeConta)
    {
        $resposta = $http->get("/lancamentos_conta/$nomeConta");

        if ($resposta->successful()) {
            if ($resposta['count'] == 0) {
                LogPersonalizado::info("Sem registro de Lançamentos para a conta '$nomeConta'");
            }

            $dados = $resposta['data'];
            $lancamentos = Cria::arrayLancamentos($dados);

            return view(
                'Conta.contaEspecifica',
                compact(
                    'nomeConta',
                    'dados',
                    'lancamentos'
                )
            );
        }

        return redirect()->route('home');
    }

    private function geraArrayContasCompleto(array $contas): array{
        $lista = array();

        foreach ($contas as $conta) {
            if (empty($conta['conta_pai'])) {
                $nomeCompleto = $conta['nome'];
                $lista[$nomeCompleto] = $nomeCompleto;
            } else {
                $nomeCompleto = $conta['conta_pai'] . '>' . $conta['nome'];

                $this->geraNomeCompletoR($contas, $conta['conta_pai'], $nomeCompleto);

                $lista[$conta['nome']] = $nomeCompleto;
            }
        }
        return $lista;
    }

    private function geraNomeCompletoR(array $contas, string $contaPaiAnterior, string &$nomeCompleto) {
        foreach ($contas as $conta) {
            if (empty($conta['conta_pai'])) {
                continue;
            } else if ($conta['nome'] == $contaPaiAnterior) {
                $nomeCompleto = $conta['conta_pai'] . '>' . $nomeCompleto;

                $this->geraNomeCompletoR($contas, $conta['conta_pai'], $nomeCompleto);
            }
        }
    }
}
