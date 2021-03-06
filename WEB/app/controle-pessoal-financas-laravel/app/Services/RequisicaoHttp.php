<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RequisicaoHttp
{

    public $verificarCertificadoSSL = false;
    private $requisicao;
    private $rotaBase;
    private $request;

    public function __construct(Request $request)
    {
        $this->requisicao = Http::withOptions([
            'verify' => $this->verificarCertificadoSSL
        ]);
        $this->rotaBase = env('API_URL', "https://localhost:8085");
        $this->request = $request;
    }

    public function setRotaBase(string $rota)
    {
        if (!empty($rota)) {
            $this->rotaBase = $rota;
        }

        return $this;
    }

    public function getRotaBase(): string
    {
        return $this->rotaBase;
    }

    public function postWithoutToken(string $rota, array $body = []): Response
    {
        $this->verificaRota($rota);

        $headers = [
            'Content-Type' => 'application:json'
        ];
        return $this->requisicao
            ->withHeaders($headers)
            ->post($this->rotaBase . $rota, $body);
    }

    public function post(string $rota, array $body = []): Response
    {
        $this->verificaRota($rota);

        $headers = [
            'Content-Type' => 'application:json'
        ];

        $token = $this->request->session()->get('token');

        return $this->requisicao
            ->withHeaders($headers)
            ->withToken($token)
            ->post($this->rotaBase . $rota, $body);
    }

    public function get(string $rota = ''): Response
    {
        $token = $this->request->session()->get('token');

        return $this->requisicao
            ->withToken($token)
            ->get($this->rotaBase . $rota);
    }

    public function getWithoutToken(string $rota = ''): Response
    {
        return $this->requisicao
            ->get($this->rotaBase . $rota);
    }

    private function verificaRota(string $rota)
    {
        $iniciaComBarra = strpos($rota, "/") === 0;
        $temTamanhoMinimo = strlen($rota) > 1;

        if (!$iniciaComBarra) {
            throw new \Exception("Rota '$rota' deve iniciar com /");
        } else if (!$temTamanhoMinimo) {
            throw new \Exception("Rota '$rota' incompleta");
        }
    }
}
