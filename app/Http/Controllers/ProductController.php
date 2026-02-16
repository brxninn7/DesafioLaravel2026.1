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

    $lancamentos = $query->latest()->paginate(12);

    $maisVendidos = Product::where('user_id', '!=', auth()->id())->take(8)->get();

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
        'descricao' => $request->descricacao,
        'preco' => $request->preco,
        'estoque' => $request->estoque,
        'marca' => $request->marca,
        'categoria' => $request->categoria,
        'tipo' => $request->tipo,
        'user_id' => \app\Models\User::factory(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Produto cadastrado!');
    }
}
