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
            <h1>Vistos Recentemente</h1>
            <div class="flex gap-10 overflow-x-auto py-4">
                @foreach ($lancamentos->where('user_id', '!=', Auth::id())->take(4) as $produto)
                    @include('partials.card-produto', ['produto' => $produto])
                @endforeach
            </div>
        </div>

        <div class="maisVendidos mt-10 relative">
            <h1>Mais vendidos</h1>
            <div class="flex gap-10 overflow-x-auto py-4">
                @foreach ($maisVendidos->where('user_id', '!=', Auth::id()) as $produto)
                    <div class="bg-white w-[300px] h-[420px] rounded text-black p-4 flex-shrink-0 flex flex-col shadow-lg">
                        <div class="imagem border border-gray-100 w-full h-[200px] rounded overflow-hidden flex items-center justify-center bg-gray-50">
                            <img src="https://placehold.co/300x200?text={{ $produto->marca }}" alt="{{ $produto->titulo }}"
                                class="object-contain w-full h-full">
                        </div>
                        <div class="informacoes mt-4 flex-grow">
                            <h2 class="font-bold text-lg truncate">{{ $produto->titulo }}</h2>
                            <p class="text-gray-500 text-sm mb-2">{{ $produto->marca }}</p>
                            <p class="preco-pix text-[22px] text-blue-700">
                                <strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                            </p>
                        </div>

                        @if(!Auth::user()->is_admin)
                        <a href="{{ route('product.show', $produto->id) }}"
                            class="bg-[#161A24] text-white text-center hover:bg-black p-[8px] w-full rounded mt-4 uppercase text-sm font-bold">
                            Comprar
                        </a>
                        @else
                        <a href="{{ route('product.show', $produto->id) }}"
                            class="bg-gray-400 text-white text-center p-[8px] w-full rounded mt-4 uppercase text-sm font-bold cursor-default">
                            Visualizar
                        </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lancamentos mt-10">
            <h1>Lançamentos</h1>
            <div class="flex gap-10 overflow-x-auto py-4">

                @foreach ($lancamentos->where('user_id', '!=', Auth::id()) as $produto)
                    <div class="bg-white w-[300px] h-[420px] rounded text-black p-4 flex-shrink-0 flex flex-col shadow-lg">
                        <div class="imagem border border-gray-100 w-full h-[200px] rounded overflow-hidden">
                            <img src="https://placehold.co/300x200?text=NOVO" class="object-contain w-full h-full">
                        </div>
                        <div class="informacoes mt-4 flex-grow">
                            <h2 class="font-bold text-lg truncate">{{ $produto->titulo }}</h2>
                            <p class="text-blue-700 font-bold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('product.show', $produto->id) }}"
                            class="bg-[#161A24] text-white text-center p-[8px] w-full rounded mt-4 uppercase text-sm font-bold">
                            {{ Auth::user()->is_admin ? 'Ver agora' : 'Comprar' }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10">
            {{ $lancamentos->links() }}
        </div>
    </div>

    <script src="{{ asset('js/landing-page.js') }}"></script>

@endsection