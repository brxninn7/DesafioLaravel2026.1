@extends('layouts.main')

@section('content')
<div class="min-h-screen py-10 px-4 text-white">
    <div class="max-w-6xl mx-auto bg-white text-black p-8 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold ">Gerenciamento de Usuários</h1>
            <a href="{{ route('admin.users.create') }}" class="bg-[#161A24] text-white px-4 py-2 rounded shadow hover:bg-black transition-all">
                <i class="bi bi-plus-lg"></i> Novo Usuário
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="py-4 px-2">Nome</th>
                        <th class="py-4 px-2">E-mail</th>
                        <th class="py-4 px-2 italic">Telefone</th>
                        <th class="py-4 px-2">Cidade/UF</th> 
                        <th class="py-4 px-2 text-center">Tipo</th>
                        <th class="py-4 px-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-2 font-semibold">{{ $user->name }}</td>
                        <td class="py-4 px-2 text-sm text-gray-600">{{ $user->email }}</td>

                        <td class="py-4 px-2 text-sm italic">{{ $user->telefone ?? 'Não cadastrado' }}</td>

                        <td class="py-4 px-2 text-sm">
                            @php
                                $address = $user->addresses instanceof \Illuminate\Database\Eloquent\Collection 
                                    ? $user->addresses->first() 
                                    : $user->addresses;
                            @endphp

                            @if($address)
                                {{ $address->cidade }} / {{ $address->estato }}
                            @else
                                <span class="text-gray-400 italic">- / -</span>
                            @endif
                        </td>

                        <td class="py-4 px-2 text-center">
                            @if($user->is_admin)
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">Admin</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">Cliente</span>
                            @endif
                        </td>

                        <td class="py-4 px-2">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700 text-lg transition-transform hover:scale-110" title="Visualizar">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 text-lg transition-transform hover:scale-110" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg transition-transform hover:scale-110" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection