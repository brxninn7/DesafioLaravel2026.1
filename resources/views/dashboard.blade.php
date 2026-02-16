@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-black">Produtos por Categoria</h3>
                <div style="height: 300px; width: 100%;">
                    <canvas id="canvasGrafico"></canvas>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-black italic">Gerenciamento de Produtos</h3>
                    <a href="{{ route('products.create') }}" class="bg-[#161A24] text-white px-4 py-2 rounded shadow hover:bg-black transition-all flex items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Cadastrar Produto
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-xs uppercase text-gray-600">
                                <th class="p-3 border-b">Título</th>
                                <th class="p-3 border-b">Preço</th>
                                <th class="p-3 border-b">Estoque</th>
                                <th class="p-3 border-b text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $p)
                            <tr class="border-b hover:bg-gray-50 text-black transition-colors">
                                <td class="p-3 font-semibold">{{ $p->titulo }}</td>
                                <td class="p-3">R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="{{ $p->estoque < 5 ? 'text-red-600 font-bold' : '' }}">
                                        {{ $p->estoque }}
                                    </span>
                                </td>
                                <td class="p-3 flex justify-center gap-4">
                                    <a href="{{ route('product.show', $p->id) }}" class="text-blue-500 hover:text-blue-700 text-xl" title="Visualizar">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <button class="text-blue-500 hover:text-blue-700 text-xl" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form class="m-0" action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Deseja excluir este produto?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xl" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onload = function() {
            const ctx = document.getElementById('canvasGrafico').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($dadosGrafico->pluck('categoria')) !!},
                    datasets: [{
                        label: 'Quantidade em Estoque',
                        data: {!! json_encode($dadosGrafico->pluck('total')) !!},
                        backgroundColor: '#161A24',
                        borderColor: '#000',
                        borderWidth: 1
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { 
                        y: { beginAtZero: true, ticks: { stepSize: 1 } } 
                    }
                }
            });
        };
    </script>
@endsection