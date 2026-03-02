<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PagSeguroService;
use App\Models\Product;

class CheckoutController extends Controller
{
    protected $pagSeguroService;

    public function __construct(PagSeguroService $pagSeguroService)
    {
        $this->pagSeguroService = $pagSeguroService;
    }

    public function store(Request $request, $productId)
    {
        $produto = Product::findOrFail($productId);
        $user = auth()->user();

        $nome = trim($user->name);
        if (!str_contains($nome, ' ')) {
            $nome .= ' Sobrenome';
        }

        $dadosCheckout = [
            'itemId1' => $produto->id,
            'itemDescription1' => substr($produto->titulo, 0, 95),
            'itemAmount1' => number_format($produto->preco, 2, '.', ''),
            'itemQuantity1' => '1',
            'reference' => 'REF_' . $user->id . '_' . time(),
            'senderName' => $nome,
            'senderEmail' => $user->email,
        ];

        try {
            $xmlString = $this->pagSeguroService->criarCheckout($dadosCheckout);

            if (str_contains($xmlString, 'Unauthorized')) {
                return redirect()->back()->with('error', 'Erro de Autenticação no PagSeguro.');
            }

            $xml = simplexml_load_string($xmlString);

            if (isset($xml->code)) {
                $url = env('PAGSEGURO_ENV') === 'sandbox' 
                    ? 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' 
                    : 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=';
                
                return redirect()->to($url . $xml->code);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Falha na conexão com a API.');
        }

        return redirect()->back()->with('error', 'Erro ao gerar checkout.');
    }
}