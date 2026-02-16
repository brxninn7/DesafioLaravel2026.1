@extends('layouts.main')

@section('title', $produto->titulo)

@section('content')
    <div class="min-h-screen py-10 px-4"> 
        
        <div class="bg-white text-black max-w-[850px] mx-auto rounded-lg p-6 shadow-2xl">
            <div class="produto flex flex-col md:flex-row gap-8">
                
                <div class="imagem flex flex-col items-center">
                    <div class="imagem-produto border border-gray-200 w-[350px] h-[350px] rounded-lg flex items-center justify-center bg-gray-50 overflow-hidden">
                        <img src="https://placehold.co/400x400?text={{ $produto->marca }}" alt="{{ $produto->titulo }}" class="object-contain w-full h-full">
                    </div>
                    
                    <div class="carrossel-imagem flex items-center mt-4 gap-2">
                        <button class="text-gray-400 hover:text-black"><i class="bi bi-chevron-left"></i></button>
                        <div class="flex gap-2">
                            <div class="w-12 h-12 border border-gray-200 rounded bg-gray-100"></div>
                            <div class="w-12 h-12 border border-gray-200 rounded bg-gray-100"></div>
                            <div class="w-12 h-12 border border-gray-200 rounded bg-gray-100"></div>
                        </div>
                        <button class="text-gray-400 hover:text-black"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>


                <div class="informacoes flex-grow">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">{{ $produto->marca }}</p>
                    <h1 class="text-3xl font-extrabold leading-tight mb-2">{{ $produto->titulo }}</h1>
                    
                    <div class="mb-6">
                        @if($produto->estoque > 0)
                            <span class="text-green-600 text-sm font-bold italic">✓ Em estoque: {{ $produto->estoque }} unidades</span>
                        @else
                            <span class="text-red-500 text-sm font-bold italic">✗ Produto esgotado</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-blue-700 text-4xl font-black">
                            R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            <span class="text-sm font-normal text-gray-500">no pix</span>
                        </p>
                        <p class="text-gray-600 text-sm mt-1">
                            ou até <strong>12x</strong> de <strong>R$ {{ number_format($produto->preco / 12, 2, ',', '.') }}</strong> sem juros
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex border border-gray-300 rounded overflow-hidden h-12">
                            <button class="px-4 hover:bg-gray-100 font-bold border-r">-</button>
                            <input type="number" value="1" class="w-12 text-center focus:outline-none border-none">
                            <button class="px-4 hover:bg-gray-100 font-bold border-l">+</button>
                        </div>
                        <button class="flex-grow bg-[#161a24] text-white font-bold h-12 rounded hover:bg-black transition-all shadow-lg uppercase tracking-wider">
                            Comprar
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-lg font-bold italic">Descrição</h3>
                <hr class="border border-black-50 rounded">
                <p class="text-gray-600 leading-relaxed text-sm pt-5 rounded">
                    {{ $produto->descricao }}
                </p>
            </div>
        </div>
    </div>
@endsection