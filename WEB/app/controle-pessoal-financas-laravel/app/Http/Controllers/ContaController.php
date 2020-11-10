<?php

namespace App\Http\Controllers;

use App\Helpers\Imprime;
use App\Services\RequisicaoHttp;
use App\Services\Token;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    public function index(Request $request, RequisicaoHttp $http, Token $token)
    {
        if ($token->valido()) {
            $resposta = $http->get('/contas');

            if ($resposta->successful()) {
                $dados = $resposta['data'];

                return view(
                    'Conta.conta',
                    compact(
                        'dados',
                    )
                );
            }

            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }

    public function contaEspecifica(Request $request, RequisicaoHttp $http, Token $token, string $nomeConta)
    {
        if ($token->valido()) {
            $resposta = $http->get("/lancamentos_conta/$nomeConta");

            if ($resposta->successful()) {
                if ($resposta['count'] == 0) {
                    Imprime::console(">>> Sem registro de Lançamentos para a conta '$nomeConta' <<<");
                }

                $dados = $resposta['data'];

                return view(
                    'Conta.contaEspecifica',
                    compact(
                        'nomeConta',
                        'dados',
                    )
                );
            }

            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }

    public function cadastro(Request $request, RequisicaoHttp $http, Token $token, string $nomeConta) {
        if ($token->valido()) {
            return view(
                'Conta.cadastro',
                compact(
                    'nomeConta',
                )
            );
        } else {
            return redirect()->route('login');
        }
    }
}
