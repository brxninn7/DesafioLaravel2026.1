<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|max:2',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        $user->addresses()->create([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estato' => $request->estado,
        ]);

        return redirect()->route('admin/users')->with('success', 'Usuário criado com sucesso!');
    }
}