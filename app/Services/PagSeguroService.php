<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PagSeguroService
{
    protected $baseUrl;
    protected $email;
    protected $token;

    public function __construct()
    {
        $this->email = config('services.pagseguro.email');
        $this->token = config('services.pagseguro.token');
        $this->baseUrl = config('services.pagseguro.sandbox') 
            ? 'https://ws.sandbox.pagseguro.uol.com.br' 
            : 'https://ws.pagseguro.uol.com.br';
    }

    public function criarCheckout(array $dados)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded; charset=ISO-8859-1'
        ])
        ->withoutVerifying()
        ->timeout(15)
        ->asForm()
        ->post("{$this->baseUrl}/v2/checkout", array_merge([
            'email' => $this->email,
            'token' => $this->token,
            'currency' => 'BRL',
        ], $dados));

        return $response->body();
    }
}