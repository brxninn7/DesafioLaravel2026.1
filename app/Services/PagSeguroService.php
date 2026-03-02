<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PagSeguroService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->token = config('services.pagseguro.token');
        $this->baseUrl = config('services.pagseguro.sandbox') 
            ? 'https://sandbox.api.pagseguro.com' 
            : 'https://api.pagseguro.com';
    }

    public function criarCheckout(array $dados)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
        ->withoutVerifying()
        ->timeout(15)
        ->post("{$this->baseUrl}/checkouts", $dados);

        return $response->json();
    }
}