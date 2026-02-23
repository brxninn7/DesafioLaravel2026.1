<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->search . '%')
                  ->orWhere('marca', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $lancamentos = $query->latest()->paginate(12);

        $maisVendidos = Product::with('images')->take(4)->get();

        return view('landing-page', compact('lancamentos', 'maisVendidos'));
    }

    public function show($id)
    {
        $produto = Product::with('images')->findOrFail($id);
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
            foreach($produto->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
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
            return back()->with('error', 'Saldo insuficiente.');
        }

        if ($product->estoque <= 0) {
            return back()->with('error', 'Produto esgotado!');
        }

        DB::transaction(function () use ($user, $product) {
            $user->decrement('saldo', $product->preco);
            $product->decrement('estoque', 1);

            Sale::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => $product->preco,
                'subprice' => $product->preco,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Compra realizada!');
    }

    public function edit($id)
    {
        $produto = Product::findOrFail($id);

        if (auth()->id() !== $produto->user_id && !auth()->user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado!');
        }

        return view('admin.products-edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Product::findOrFail($id);

        if (auth()->id() !== $produto->user_id && !auth()->user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado!');
        }

        $produto->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'marca' => $request->marca,
            'categoria' => $request->categoria,
            'tipo' => $request->tipo,
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('produtos', 'public');
                $produto->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produto atualizado!');
    }
}