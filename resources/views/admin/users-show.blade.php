@extends('layouts.main')

@section('content')
<div class="min-h-screen py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white text-black p-8 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-2xl font-bold italic">Detalhes do Usuário</h1>
            <a href="{{ route('admin/users') }}" class="text-gray-500 hover:text-black">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-gray-50 p-4 rounded shadow-sm">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Nome Completo</p>
                <p class="font-semibold">{{ $user->name }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded shadow-sm">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">E-mail</p>
                <p class="font-semibold">{{ $user->email }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded shadow-sm">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1 italic">Telefone de Contato</p>
                <p class="font-semibold">{{ $user->telefone ?? 'Não cadastrado' }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded shadow-sm">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Saldo em Conta</p>
                <p class="font-semibold text-green-600">R$ {{ number_format($user->saldo, 2, ',', '.') }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded shadow-sm md:col-span-2">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Endereço Completo</p>
                @if($user->addresses->count() > 0)
                    @php $addr = $user->addresses->first(); @endphp
                    <p class="font-semibold">
                        {{ $addr->logradouro }}, {{ $addr->numero }} - {{ $addr->bairro }}
                    </p>
                    <p class="font-semibold">
                        {{ $addr->cidade }} / {{ $addr->estato }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1 italic">CEP: {{ $addr->cep }}</p>
                @else
                    <p class="text-sm text-red-500 italic">Nenhum endereço cadastrado para este usuário.</p>
                @endif
            </div>

            <div class="bg-gray-50 p-4 rounded shadow-sm md:col-span-2">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Informações Adicionais</p>
                <p class="text-sm">Conta criada em: {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-sm">Última atualização: {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition shadow-lg">
                Editar Perfil
            </a>
        </div>
    </div>
</div>
@endsection