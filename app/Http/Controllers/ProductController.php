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
}
