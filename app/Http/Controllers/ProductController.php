<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $maisVendidos = Product::orderBy('id', 'desc')->take(10)->get();

        $lancamentos = Product::latest()->take(10)->get();

        return view('landing-page', compact('maisVendidos', 'lancamentos'));
    }

    public function show($id)
    {
    
    $produto = Product::findOrFail($id);

    return view('pagina-individual', compact('produto'));
    }

    public function create()
    {
    return view('admin.products-create');
    }

    public function store(Request $request)
    {

    Product::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricacao,
        'preco' => $request->preco,
        'estoque' => $request->estoque,
        'marca' => $request->marca,
        'categoria' => $request->categoria,
        'tipo' => $request->tipo,
    ]);

    return redirect()->route('dashboard')->with('success', 'Produto cadastrado!');
    }
}
