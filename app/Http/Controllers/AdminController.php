<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Address;
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

        $usuarios = User::with('addresses')->where('is_admin', false)->paginate(10);
        return view('admin.users', compact('usuarios'));
    }

    public function showUser($id)
    {
        $user = User::with('addresses')->findOrFail($id);
        return view('admin.users-show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::with('addresses')->findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {   
        $user = User::findOrFail($id);

        $user->update($request->only(['name', 'telefone', 'saldo']));

        $user->addresses()->updateOrCreate(
            ['user_id' => $user->id], 
            [
                'cep' => $request->cep,
                'cidade' => $request->cidade,
                'logradouro' => $request->logradouro ?? 'Não informado',
                'bairro' => $request->bairro ?? 'Não informado',
                'estato' => $request->estado ?? 'MG',
                
            ]
        );

        return redirect()->route('admin/users')->with('success', 'Usuário e endereço atualizados com sucesso!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuário removido com sucesso!');
    }
}