@extends('layouts.main')

@section('title', 'Histórico de Vendas')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6 text-white tracking-tight">
        {{ auth()->user()->is_admin ? 'Histórico Global de Vendas' : 'Minhas Vendas' }}
    </h1>

    <div class="bg-white p-6 rounded-lg mb-8 shadow-sm border border-gray-100">
        <h3 class="text-gray-500 uppercase text-[10px] font-black tracking-widest mb-4">Evolução Mensal de Vendas</h3>
        <div style="height: 300px; width: 100%;">
            <canvas id="vendasChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg mb-8 shadow-sm border border-gray-100">
        <form action="{{ route('admin.sales.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
            <div>
                <label class="block text-gray-500 text-[10px] font-black uppercase mb-2">Data Inicial</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" 
                    class="bg-gray-50 border-gray-200 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            
            <div>
                <label class="block text-gray-500 text-[10px] font-black uppercase mb-2">Data Final</label>
                <input type="date" name="data_fim" value="{{ request('data_fim') }}" 
                    class="bg-gray-50 border-gray-200 text-gray-900 rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white font-black text-xs uppercase px-6 py-3 rounded transition-all">
                    Filtrar
                </button>
                
                <button type="submit" name="export" value="pdf" class="bg-red-600 hover:bg-red-500 text-white font-black text-xs uppercase px-6 py-3 rounded transition-all">
                    PDF
                </button>
                
                @if(auth()->user()->is_admin)
                <button type="submit" name="export" value="xlsx" class="bg-green-600 hover:bg-green-500 text-white font-black text-xs uppercase px-6 py-3 rounded transition-all">
                    Excel
                </button>
                @endif
            </div>

            @if(request()->filled('data_inicio') || request()->filled('data_fim'))
                <a href="{{ route('admin.sales.index') }}" class="text-gray-400 hover:text-black text-xs uppercase font-bold transition-all ml-auto">
                    Limpar Filtros
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-[10px] uppercase font-black text-gray-600">
                        <th class="p-4 border-b">Foto</th>
                        <th class="p-4 border-b">Produto</th>
                        <th class="p-4 border-b">Categoria</th>
                        <th class="p-4 border-b">Vendedor</th>
                        <th class="p-4 border-b">Comprador</th>
                        <th class="p-4 border-b">Data</th>
                        <th class="p-4 border-b text-right">Valor</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @foreach($vendas as $venda)
                    <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                        <td class="p-4">
                            <img src="{{ $venda->product->foto ? asset('storage/'.$venda->product->foto) : 'https://placehold.co/50x50' }}" class="w-12 h-12 object-cover rounded border">
                        </td>
                        <td class="p-4 font-semibold">{{ $venda->product->titulo ?? 'Removido' }}</td>
                        <td class="p-4 text-gray-500 text-xs uppercase">{{ $venda->product->categoria ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $venda->product->user->name ?? 'Sistema' }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $venda->user->name ?? 'N/A' }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 text-right font-black text-blue-600">
                            R$ {{ number_format($venda->unit_price, 2, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $vendas->appends(request()->query())->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('vendasChart').getContext('2d');
        const dados = @json($dadosGrafico);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dados.map(d => d.mes),
                datasets: [{
                    label: 'Vendas',
                    data: dados.map(d => d.total),
                    borderColor: '#161A24',
                    backgroundColor: 'rgba(22, 26, 36, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#161A24'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', stepSize: 1 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                }
            }
        });
    });
</script>
@endsection