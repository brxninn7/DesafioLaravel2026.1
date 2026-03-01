@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-7xl mx-auto space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm mb-6"
                    role="alert">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm"
                    role="alert">
                    <strong class="font-bold">Erro!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow sm:rounded-lg md:col-span-2">
                    <h3 class="text-lg font-bold mb-4 text-black">Produtos por Categoria</h3>
                    <div style="height: 300px; width: 100%;">
                        <canvas id="canvasGrafico"></canvas>
                    </div>
                </div>

                <div class="p-6 bg-white shadow sm:rounded-lg flex flex-col justify-center items-center text-center">
                    <h3 class="text-gray-500 uppercase text-xs font-bold tracking-widest mb-2">Seu Saldo Disponível</h3>
                    <div class="text-4xl font-black text-green-600">
                        R$ {{ number_format(auth()->user()->saldo, 2, ',', '.') }}
                    </div>
                    <a href="{{ route('profile.edit') }}" class="mt-4 text-sm text-blue-600 hover:underline">
                        Gerenciar Carteira
                    </a>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-black">Meus Produtos Cadastrados</h3>
                    @if (!auth()->user()->is_admin)
                        <a href="{{ route('products.create') }}"
                            class="bg-[#161A24] text-white px-4 py-2 rounded shadow hover:bg-black transition-all flex items-center gap-2">
                            <i class="bi bi-plus-lg"></i> Cadastrar Produto
                        </a>
                    @endif
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
                            @forelse ($produtos as $p)
                                <tr class="border-b hover:bg-gray-50 text-black transition-colors">
                                    <td class="p-3 font-semibold">{{ $p->titulo }}</td>
                                    <td class="p-3">R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                                    <td class="p-3 text-sm">
                                        <span class="{{ $p->estoque < 5 ? 'text-red-600 font-bold' : '' }}">
                                            {{ $p->estoque }} unidades
                                        </span>
                                    </td>
                                    <td class="p-3 flex justify-center gap-4">
                                        <a href="{{ route('product.show', $p->id) }}"
                                            class="text-blue-500 hover:text-blue-700 text-xl"><i
                                                class="bi bi-eye-fill"></i></a>

                                        <a href="{{ route('products.edit', $p->id) }}"
                                            class="text-blue-500 hover:text-blue-700 text-xl">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form class="m-0" action="{{ route('products.destroy', $p->id) }}"
                                            method="POST" onsubmit="return confirm('Excluir produto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xl"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500">Você ainda não cadastrou
                                        produtos.</td>
                                </tr>
                            @endforelse
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
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        };
    </script>
@endsection
