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
                <p class="font-semibold">
                    {{ $user->logradouro }}, {{ $user->bairro }} - {{ $user->cidade }}/{{ $user->estado }}
                </p>
                <p class="text-sm text-gray-500 mt-1 italic">CEP: {{ $user->cep }}</p>
            </div>
        </div>
    </div>
</div>
@endsection