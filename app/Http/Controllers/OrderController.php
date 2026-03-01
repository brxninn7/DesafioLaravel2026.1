<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportPdf()
    {
        $compras = Sale::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->take(20)
            ->get();
        
        $pdf = Pdf::loadView('orders.pdf', compact('compras'));
        
        return $pdf->download('minhas-compras.pdf');
    }
}