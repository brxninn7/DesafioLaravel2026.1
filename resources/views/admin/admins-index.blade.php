@extends('layouts.main')

@section('title', 'Gerenciamento de Administradores')

@section('content')

    <div class="py-12 bg-gradient-to-b from-[#161A24] to-[#121316] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h2 class="font-semibold text-xl text-white leading-tight italic uppercase tracking-widest">
                    Gerenciamento de Administradores
                </h2>
            </div>
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded-lg shadow font-bold text-sm uppercase">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-500 text-white rounded-lg shadow font-bold text-sm uppercase">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="text-lg font-black text-black uppercase tracking-tighter">Administradores</h3>
                            <p class="text-sm text-gray-500">Listagem de usuários com permissões de gestão.</p>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="bg-[#161A24] text-white px-6 py-2 rounded font-bold text-xs uppercase hover:bg-black transition-all shadow-md">
                            + Novo Admin
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400">Foto</th>
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400">Nome / CPF</th>
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400">Contato / E-mail</th>
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400">Endereço</th>
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400">Nascimento</th>
                                    <th class="py-4 px-4 text-[10px] font-black uppercase text-gray-400 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <img src="{{ $admin->foto ? asset('storage/' . $admin->foto) : asset('img/default-user.png') }}" class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="font-bold text-black flex items-center gap-2">
                                                {{ $admin->name }}
                                                @if($admin->id === auth()->id())
                                                    <span class="text-[8px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black uppercase tracking-tighter">Sua Conta</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-gray-500">{{ $admin->cpf ?? 'Sem CPF' }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-sm text-gray-800 font-medium">{{ $admin->telefone ?? 'Sem Telefone' }}</div>
                                            <div class="text-xs text-gray-500">{{ $admin->email }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($admin->addresses->first())
                                                <div class="text-[10px] text-gray-700 leading-tight">
                                                    {{ $admin->addresses->first()->logradouro }}, {{ $admin->addresses->first()->numero }}<br>
                                                    {{ $admin->addresses->first()->bairro }} - {{ $admin->addresses->first()->cidade }}/{{ $admin->addresses->first()->estato }}
                                                </div>
                                            @else
                                                <span class="text-[10px] text-gray-400">Sem endereço</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-xs text-gray-600">
                                            {{ $admin->data_nascimento ? \Carbon\Carbon::parse($admin->data_nascimento)->format('d/m/Y') : 'Não informada' }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex justify-center items-center gap-5">

                                                <a href="{{ route('admin.users.show', $admin->id) }}" class="text-blue-500 hover:text-blue-700 transition-transform hover:scale-110" title="Visualizar">
                                                    <i class="bi bi-eye-fill text-lg"></i>
                                                </a>

                                                @if($admin->id === auth()->id() || $admin->created_by === auth()->id())
                                                    <a href="{{ route('admin.users.edit', $admin->id) }}" class="text-blue-500 hover:text-blue-700 transition-transform hover:scale-110" title="Editar">
                                                        <i class="bi bi-pencil-square text-lg"></i>
                                                    </a>
                                                    
                                                    @if($admin->id !== auth()->id())
                                                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este administrador?')" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-transform hover:scale-110" title="Excluir">
                                                                <i class="bi bi-trash-fill text-lg"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <i class="bi bi-lock-fill text-gray-300 text-lg" title="Apenas o criador pode alterar este admin"></i>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($admins->hasPages())
                        <div class="mt-6 border-t border-gray-100 pt-4">
                            {{ $admins->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection