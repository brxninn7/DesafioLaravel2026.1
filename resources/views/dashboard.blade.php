@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Controle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-black">Gráfico de Produtos por Categoria</h3>
                <div style="height: 300px;">
                    <canvas id="canvasGrafico"></canvas>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-black">Gerenciamento de Produtos</h3>
                    <a href="{{ route('products.create') }}" class="bg-[#161A24] text-white px-4 py-2 rounded shadow hover:bg-black transition-colors">
                        <i class="bi bi-plus-lg"></i> Cadastrar Produto
                    </a>
                </div>
                
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-xs uppercase text-gray-600">
                            <th class="p-3">Título</th>
                            <th class="p-3">Preço</th>
                            <th class="p-3">Estoque</th>
                            <th class="p-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produtos as $p)
                        <tr class="border-b hover:bg-gray-50 text-black">
                            <td class="p-3 font-semibold">{{ $p->titulo }}</td>
                            <td class="p-3">R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                            <td class="p-3">{{ $p->estoque }}</td>
                            <td class="p-3 flex gap-4">

                                <button class="text-blue-500 hover:text-blue-700 text-[18px] transition-colors"><i class="bi bi-eye-fill"></i></button>
                                <button class="text-blue-500 hover:text-blue-700 mr-2 ml-2 transition-colors"><i class="bi bi-pencil-square"></i></button>
                                
                                <form class="m-0" action="{{ route('products.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 transition-colors mb-0"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('canvasGrafico');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dadosGrafico->pluck('categoria')) !!},
                datasets: [{
                    label: 'Quantidade de Itens',
                    data: {!! json_encode($dadosGrafico->pluck('total')) !!},
                    backgroundColor: '#161A24'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>