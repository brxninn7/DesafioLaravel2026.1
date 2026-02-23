<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $compras = Sale::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->get();

        return view('compras', compact('compras'));
    }
}