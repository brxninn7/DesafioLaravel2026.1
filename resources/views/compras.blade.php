@extends('layouts.main')

@section('title', 'Minhas Compras')

@section('content')

<div class="font-poppins text-white px-10 py-10 mx-auto max-w-7xl">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-blue-700 p-3 rounded-lg">
                <i class="bi bi-bag-check-fill text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold">Minhas Compras</h1>
        </div>

        @if(!$compras->isEmpty())
            <a href="{{ route('orders.pdf') }}" class="bg-white text-black px-6 py-2 rounded font-black text-xs uppercase hover:bg-gray-200 transition-all flex items-center gap-2 shadow-lg">
                <i class="bi bi-file-earmark-pdf-fill text-lg"></i>
                Baixar PDF
            </a>
        @endif
    </div>

    @if($compras->isEmpty())
        <div class="bg-[#161A24] border border-gray-700 rounded-lg p-10 text-center">
            <p class="text-gray-400 text-lg">Você ainda não realizou nenhuma compra.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-700 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition">
                Ir às compras
            </a>
        </div>
    @else
        <div class="overflow-x-auto bg-[#161A24] rounded-lg border border-gray-700 shadow-xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1c222d] text-gray-300 uppercase text-sm">
                        <th class="p-5 border-b border-gray-700">Produto</th>
                        <th class="p-5 border-b border-gray-700">Marca</th>
                        <th class="p-5 border-b border-gray-700 text-center">Data</th>
                        <th class="p-5 border-b border-gray-700 text-right">Valor Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="p-5 border-b border-gray-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
                                        <img src="{{ $compra->product->foto ? asset('storage/' . $compra->product->foto) : 'https://placehold.co/100x100?text=IMG' }}" class="object-contain w-full h-full">
                                    </div>
                                    <span class="font-semibold">{{ $compra->product->titulo }}</span>
                                </div>
                            </td>
                            <td class="p-5 border-b border-gray-800 text-gray-400">
                                {{ $compra->product->marca }}
                            </td>
                            <td class="p-5 border-b border-gray-800 text-center text-gray-400">
                                {{ $compra->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-5 border-b border-gray-800 text-right text-blue-500 font-bold text-lg">
                                R$ {{ number_format($compra->unit_price, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection