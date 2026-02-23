@extends('layouts.main')

@section('title', 'Home')

@section('content')

    <div x-data="{
        index: 0,
        images: [
            '{{ asset('img/carrosselImg/banner-artisan-j86z7z3rmj.webp') }}',
            '{{ asset('img/carrosselImg/banner-teclado-wooting-1-uzfiey3cz2.webp') }}',
            '{{ asset('img/carrosselImg/banner-razer-1-1lbd24gcp9.webp') }}'
        ]
    }" 
    class="relative w-[80%] h-[500px] overflow-hidden mx-auto max-w-7xl mt-10 rounded">
        <template x-for="(img, i) in images" :key="i">
            <img :src="img" x-show="index === i"
                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" alt="">
        </template>

        <button @click="index = (index - 1 + images.length) % images.length"
            class="absolute left-5 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-2 rounded-full hover:bg-white/20 transition-colors">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button @click="index = (index + 1) % images.length"
            class="absolute right-5 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-2 rounded-full hover:bg-white/20 transition-colors">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="font-poppins text-white font-semibold text-[20px] px-10 py-5 mx-auto max-w-7xl">

        <div class="flex gap-4 mb-6">
            <span class="text-sm self-center">Filtrar por:</span>
            <a href="{{ route('home') }}" class="text-sm bg-gray-700 px-3 py-1 rounded hover:bg-gray-600 transition">Todos</a>
            <a href="{{ route('home', ['categoria' => 'Teclado']) }}" class="text-sm bg-gray-700 px-3 py-1 rounded hover:bg-gray-600 transition">Teclados</a>
            <a href="{{ route('home', ['categoria' => 'Mouse']) }}" class="text-sm bg-gray-700 px-3 py-1 rounded hover:bg-gray-600 transition">Mouses</a>
            <a href="{{ route('home', ['categoria' => 'GPU']) }}" class="text-sm bg-gray-700 px-3 py-1 rounded hover:bg-gray-600 transition">GPUs</a>
        </div>

        <div class="recentes mt-10">
            <h1 class="text-2xl mb-4">
                @if(request('search'))
                    Resultados para: "{{ request('search') }}"
                @else
                    Vistos Recentemente
                @endif
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $produtosExibidos = (request('search') || request('categoria')) ? $lancamentos : $lancamentos->take(4);
                @endphp

                @forelse ($produtosExibidos as $produto)
                    <div class="bg-white rounded text-black p-4 flex flex-col shadow-lg border border-gray-200">
                        <div class="imagem border border-gray-100 w-full h-[200px] rounded overflow-hidden flex items-center justify-center bg-gray-50">
                            @if($produto->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $produto->images->first()->image_path) }}" class="object-contain w-full h-full">
                            @else
                                <img src="https://placehold.co/300x200?text=SEM+FOTO" class="object-contain w-full h-full">
                            @endif
                        </div>
                        
                        <div class="informacoes mt-4 flex-grow">
                            <h2 class="font-bold text-lg truncate">{{ $produto->titulo }}</h2>
                            <p class="text-gray-500 text-sm mb-2">{{ $produto->marca }}</p>
                            <p class="text-[22px] text-blue-700 font-bold">
                                R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </p>
                        </div>

                        @if(Auth::check() && !Auth::user()->is_admin)
                            <a href="{{ route('product.show', $produto->id) }}"
                                class="bg-[#161A24] text-white text-center hover:bg-black p-[10px] w-full rounded mt-4 uppercase text-sm font-bold transition">
                                Comprar
                            </a>
                        @else
                            <a href="{{ route('product.show', $produto->id) }}"
                                class="bg-gray-500 text-white text-center hover:bg-gray-600 p-[10px] w-full rounded mt-4 uppercase text-sm font-bold transition">
                                Visualizar
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center text-gray-400">
                        Nenhum produto encontrado.
                    </div>
                @endforelse
            </div>
        </div>

        @if(!request('search') && !request('categoria'))
            <div class="maisVendidos mt-10">
                <h1 class="text-2xl mb-4">Mais vendidos</h1>
                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-4 gap-6">
                    @foreach ($maisVendidos as $produto)
                        <div class="bg-white rounded text-black p-4 flex flex-col shadow-lg border border-gray-200">
                            <div class="imagem border border-gray-100 w-full h-[200px] rounded overflow-hidden flex items-center justify-center bg-gray-50">
                                @if($produto->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $produto->images->first()->image_path) }}" class="object-contain w-full h-full">
                                @else
                                    <img src="https://placehold.co/300x200?text={{ $produto->marca }}" class="object-contain w-full h-full">
                                @endif
                            </div>

                            <div class="informacoes mt-4 flex-grow">
                                <h2 class="font-bold text-lg truncate">{{ $produto->titulo }}</h2>
                                <p class="text-gray-500 text-sm mb-2">{{ $produto->marca }}</p>
                                <p class="text-[22px] text-blue-700 font-bold">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </p>
                            </div>

                            @if(Auth::check() && !Auth::user()->is_admin)
                                <a href="{{ route('product.show', $produto->id) }}"
                                    class="bg-[#161A24] text-white text-center hover:bg-black p-[10px] w-full rounded mt-4 uppercase text-sm font-bold transition">
                                    Comprar
                                </a>
                            @else
                                <a href="{{ route('product.show', $produto->id) }}"
                                    class="bg-gray-500 text-white text-center hover:bg-gray-600 p-[10px] w-full rounded mt-4 uppercase text-sm font-bold transition">
                                    Visualizar
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-10">
            {{ $lancamentos->appends(request()->query())->links() }}
        </div>
    </div>

    <script src="{{ asset('js/landing-page.js') }}"></script>

@endsection