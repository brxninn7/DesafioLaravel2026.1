<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PagSeguroService;
use App\Models\Product;
use App\Models\Sale;

class CheckoutController extends Controller
{
    protected $pagSeguroService;

    public function __construct(PagSeguroService $pagSeguroService)
    {
        $this->pagSeguroService = $pagSeguroService;
    }

    public function store(Request $request)
    {
        $produto = Product::findOrFail($request->product_id);
        $user = auth()->user();
        $quantidade = (int) $request->input('quantidade', 1);

        $dadosCheckout = [
            "customer" => [
                "name" => $user->name . " Sobrenome",
                "email" => $user->email,
            ],
            "items" => [
                [
                    "reference_id" => (string) $produto->id,
                    "name" => substr($produto->titulo, 0, 64),
                    "quantity" => $quantidade,
                    "unit_amount" => (int) ($produto->preco * 100)
                ]
            ],
            "payment_methods" => [
                ["type" => "CREDIT_CARD"],
                ["type" => "BOLETO"],
                ["type" => "PIX"]
            ],
            "redirect_url" => route('home'),
        ];

        $resultado = $this->pagSeguroService->criarCheckout($dadosCheckout);

        if (isset($resultado['links'])) {
            
            Sale::create([
                'user_id' => $user->id,
                'product_id' => $produto->id,
                'quantidade' => $quantidade,
                'unit_price' => $produto->preco,
                'subprice' => $produto->preco * $quantidade,
                'status' => 'pendente', 
                'reference' => 'REF_' . time()
            ]);

            foreach ($resultado['links'] as $link) {
                if ($link['rel'] == 'PAY') {
                    return redirect()->to($link['href']);
                }
            }
        }

        return redirect()->back()->with('error', 'Erro ao processar pagamento.');
    }
}