<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $product = Product::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
            'tipo' => $request->tipo,
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('produtos', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produto cadastrado!');
    }

    public function destroy($id)
    {
        $produto = Product::findOrFail($id);

        if (auth()->user()->is_admin || $produto->user_id == auth()->id()) {
            $produto->delete();

            return redirect()->back()->with('success', 'Removido!');
        }

        return redirect()->back()->with('error', 'Acesso negado!');
    }

    public function buy($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();

        if ($user->saldo < $product->preco) {
            return back()->with('error', 'Saldo insuficiente. Adiciona fundos na tua carteira.');
        }

        if ($product->estoque <= 0) {
            return back()->with('error', 'Este produto já esgotou!');
        }

        DB::transaction(function () use ($user, $product) {
            $user->decrement('saldo', $product->preco);
            $product->decrement('estoque', 1);
        });

        return redirect()->route('dashboard')->with('success', 'Compra realizada com sucesso!');
    }

    public function edit($id)
    {
        $produto = Product::findOrFail($id);

        if (auth()->id() !== $produto->user_id && ! auth()->user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado!');
        }

        return view('admin.products-edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Product::findOrFail($id);

        if (auth()->id() !== $produto->user_id && ! auth()->user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado!');
        }

        $produto->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');
    }
}
