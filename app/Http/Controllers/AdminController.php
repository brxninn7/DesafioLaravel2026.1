<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Address;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\AdminContactUser;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $dadosGrafico = Product::select('categoria', DB::raw('count(*) as total'))->groupBy('categoria')->get();
        $produtos = Product::all();

        return view('dashboard', compact('produtos', 'dadosGrafico'));
    }

    public function sendEmailToUser(Request $request, $id)
    {
        $request->validate([
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        Mail::to($user->email)->send(new AdminContactUser($user, $request->assunto, $request->mensagem));

        return redirect()->back()->with('success', 'E-mail enviado com sucesso para ' . $user->name);
    }

    public function salesHistory(Request $request)
    {
        $query = Sale::with(['user', 'product.user']);

        if (!auth()->user()->is_admin) {
            $query->whereHas('product', function($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        if ($request->export == 'pdf') {
            $vendasParaExportar = $query->get();
            $pdf = Pdf::loadView('orders.pdf', ['compras' => $vendasParaExportar]);
            return $pdf->download('relatorio-vendas.pdf');
        }

        if ($request->export == 'xlsx' && auth()->user()->is_admin) {
            $vendasParaExportar = $query->get();
            return Excel::download(new SalesExport($vendasParaExportar), 'relatorio-vendas.xlsx');
        }

        $vendas = $query->latest()->paginate(10);

        return view('admin.sales-index', compact('vendas'));
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