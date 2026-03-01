<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function admins()
    {
        $admins = User::where('is_admin', true)->paginate(10);
        return view('admin.admins-index', compact('admins'));
    }

    public function showUser($id)
    {
        $user = User::with('addresses')->findOrFail($id);
        return view('admin.users-show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::with('addresses')->findOrFail($id);

        if ($user->is_admin) {
            if ($user->id !== auth()->id() && $user->created_by !== auth()->id()) {
                return redirect()->back()->with('error', 'Ação não permitida.');
            }
        }

        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {   
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            if ($user->id !== auth()->id() && $user->created_by !== auth()->id()) {
                return redirect()->back()->with('error', 'Ação não permitida.');
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $userData = $request->only(['name', 'email', 'telefone', 'saldo', 'cpf', 'data_nascimento']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }
            $userData['foto'] = $request->file('foto')->store('users', 'public');
        }

        $user->update($userData);

        $user->addresses()->updateOrCreate(
            ['user_id' => $user->id], 
            [
                'cep' => $request->cep,
                'cidade' => $request->cidade,
                'logradouro' => $request->logradouro ?? 'Não informado',
                'numero' => $request->numero ?? 'S/N',
                'bairro' => $request->bairro ?? 'Não informado',
                'estato' => $request->estado ?? 'MG',
            ]
        );

        $route = $user->is_admin ? 'admin.admins.index' : 'admin/users';
        return redirect()->route($route)->with('success', 'Atualizado com sucesso!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            if ($user->id === auth()->id() || $user->created_by !== auth()->id()) {
                return redirect()->back()->with('error', 'Ação não permitida.');
            }
        }

        if ($user->foto) {
            Storage::delete('public/' . $user->foto);
        }

        $user->delete();
        return redirect()->back()->with('success', 'Removido com sucesso!');
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('users', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'foto' => $fotoPath,
            'is_admin' => $request->has('is_admin'),
            'created_by' => auth()->id()
        ]);

        $user->addresses()->create([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estato' => $request->estado
        ]);

        return redirect()->route('admin/users')->with('success', 'Criado com sucesso!');
    }
}