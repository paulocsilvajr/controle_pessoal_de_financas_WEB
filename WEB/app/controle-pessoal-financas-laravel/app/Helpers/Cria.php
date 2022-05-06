<?php

namespace App\Helpers;

use App\Models\Conta;
use App\Models\Lancamento;

final class Cria
{
    public static function arrayContas(array $dados): array
    {
        return Cria::arrayTipado($dados, Conta::class);
    }

    public static function arrayLancamentos(array $dados): array
    {
        return Cria::arrayTipado($dados, Lancamento::class);
    }

    private static function arrayTipado($dados, $construtor): array
    {
        $array = array();
        foreach ($dados as $dado) {
            $array[] = new $construtor($dado);
        }
        return $array;
    }
}
