<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {

        $dadosGrafico = Product::select('categoria', DB::raw('count(*) as total'))->groupBy('categoria')->get();

        $produtos = Product::all();

        return view('dashboard', compact('produtos', 'dadosGrafico'));
    }

    public function users()
    {

        $usuarios = User::all();
        
        return view('admin.users', compact('usuarios'));
    }
}