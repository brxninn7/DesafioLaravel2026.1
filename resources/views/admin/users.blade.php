@extends('layouts.main')

@section('content')
<div class="min-h-screen py-10 px-4 text-white">
    <div class="max-w-6xl mx-auto bg-white text-black p-8 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Usuários</h1>
            <span class="bg-gray-200 px-3 py-1 rounded text-sm font-semibold">Total: {{ $usuarios->count() }}</span>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-100 text-gray-400 uppercase text-xs">
                    <th class="py-3">Nome</th>
                    <th class="py-3">E-mail</th>
                    <th class="py-3">Tipo</th>
                    <th class="py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 font-medium">{{ $user->name }}</td>
                    <td class="py-4">{{ $user->email }}</td>
                    <td class="py-4">
                        @if($user->is_admin)
                            <span class=" text-red-500 px-2 py-1 rounded text-xs font-bold">Admin</span>
                        @else
                            <span class="text-gray-600 px-2 py-1 rounded text-xs">Cliente</span>
                        @endif
                    </td>
                    <td class="py-4 text-center">
                        <button class="text-blue-500 hover:text-blue-700 text-[18px] transition-colors"><i class="bi bi-eye-fill"></i></button>
                        <button class="text-blue-500 hover:text-blue-700 mr-2 ml-2 transition-colors"><i class="bi bi-pencil-square"></i></button>
                        <button class="text-red-500 hover:text-red-700 transition-colors"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection