<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            $produtos = Product::all();
 
            $dadosGrafico = Product::select('categoria', DB::raw('count(*) as total'))
                ->groupBy('categoria')
                ->get();
        } else {
            $produtos = Product::where('user_id', $user->id)->get();

            $dadosGrafico = collect(); 
        }

        return view('dashboard', compact('produtos', 'dadosGrafico'));
    }
}