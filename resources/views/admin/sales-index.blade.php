@extends('layouts.main')

@section('title', 'Histórico de Vendas')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6 text-white uppercase tracking-widest">
        {{ auth()->user()->is_admin ? 'Histórico Global de Vendas' : 'Minhas Vendas' }}
    </h1>

    <div class="bg-[#1c222d] p-6 rounded-lg mb-8 border border-gray-700">
        <form action="{{ route('admin.sales.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
            <div>
                <label class="block text-gray-400 text-[10px] font-black uppercase mb-2">Data Inicial</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" 
                    class="bg-[#161A24] border-gray-600 text-white rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            
            <div>
                <label class="block text-gray-400 text-[10px] font-black uppercase mb-2">Data Final</label>
                <input type="date" name="data_fim" value="{{ request('data_fim') }}" 
                    class="bg-[#161A24] border-gray-600 text-white rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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
                <a href="{{ route('admin.sales.index') }}" class="text-gray-500 hover:text-white text-xs uppercase font-bold transition-all ml-auto">
                    Limpar Filtros
                </a>
            @endif
        </form>
    </div>

    <div class="bg-[#161A24] rounded-lg border border-gray-700 overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#1c222d] text-gray-300 uppercase text-xs font-black">
                    <th class="p-4 border-b border-gray-700">Foto</th>
                    <th class="p-4 border-b border-gray-700">Produto</th>
                    <th class="p-4 border-b border-gray-700">Categoria</th>
                    <th class="p-4 border-b border-gray-700">Vendedor</th>
                    <th class="p-4 border-b border-gray-700">Comprador</th>
                    <th class="p-4 border-b border-gray-700">Data</th>
                    <th class="p-4 border-b border-gray-700 text-right">Valor</th>
                </tr>
            </thead>
            <tbody class="text-white">
                @foreach($vendas as $venda)
                <tr class="hover:bg-white/5 transition-colors border-b border-gray-800">
                    <td class="p-4">
                        <img src="{{ $venda->product->foto ? asset('storage/'.$venda->product->foto) : 'https://placehold.co/50x50' }}" class="w-12 h-12 object-cover rounded">
                    </td>
                    <td class="p-4 font-semibold">{{ $venda->product->titulo ?? 'Removido' }}</td>
                    <td class="p-4 text-gray-400 text-xs">{{ $venda->product->categoria ?? 'N/A' }}</td>
                    <td class="p-4 text-gray-400 text-xs">{{ $venda->product->user->name ?? 'Sistema' }}</td>
                    <td class="p-4 text-gray-400 text-xs">{{ $venda->user->name ?? 'N/A' }}</td>
                    <td class="p-4 text-gray-400 text-xs">{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-right font-bold text-blue-500">
                        R$ {{ number_format($venda->unit_price, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $vendas->appends(request()->query())->links() }}
    </div>
</div>
@endsection