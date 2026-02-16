<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $query = Product::query();

    
    if ($request->has('categoria') && $request->categoria != '') {
        $query->where('categoria', $request->categoria);
    }

    if (auth()->check()) {
        $query->where('user_id', '!=', auth()->id());
    }

    $lancamentos = $query->latest()->paginate(12);

    $queryMaisVendidos = Product::query();
    if (auth()->check()) {
        $queryMaisVendidos->where('user_id', '!=', auth()->id());
    }
    $maisVendidos = $queryMaisVendidos->take(4)->get();

    return view('landing-page', compact('lancamentos', 'maisVendidos'));
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
        'descricao' => $request->descricao,
        'preco' => $request->preco,
        'estoque' => $request->estoque,
        'marca' => $request->marca,
        'categoria' => $request->categoria,
        'tipo' => $request->tipo,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Produto cadastrado!');
    }
}
