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
    }" class="relative w-[80%] h-[500px] overflow-hidden mx-auto max-w-7xl mt-10 rounded">
        <template x-for="(img, i) in images" :key="i">
            <img :src="img" x-show="index === i"
                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" alt="">
        </template>

        <button @click="index = (index - 1 + images.length) % images.length"
            class="absolute left-5 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-2 rounded-full hover:bg-white/20 transition-colors"><i
                class="bi bi-chevron-left"></i></button>
        <button @click="index = (index + 1) % images.length"
            class="absolute right-5 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-2 rounded-full hover:bg-white/20 transition-colors"><i
                class="bi bi-chevron-right"></i></button>
    </div>

    <div class="font-poppins text-white font-semibold text-[20px] px-10 py-5 mx-auto max-w-7xl">
        <div class="recentes relative mt-10" x-data="{
            paginaAtual: 0,
            larguraGrupo: 1120,
        }">
            <h1>Vistos Recentemente</h1>
            <button @click="if (paginaAtual > 0) paginaAtual--" class="absolute left-0 top-1/2 -translate-y-1/2 z-10"><i class="bi bi-chevron-left rounded"></i></button>
            <div class="overflow-hidden w-[1120px] mx-auto">
                <div class="flex gap-10 transition-transform duration-500" :style="`transform: translateX(-${paginaAtual * larguraGrupo}px)`">

                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                
                </div>
            </div>
            <button @click="if (paginaAtual < 2) paginaAtual++" class="absolute right-0 top-1/2 -translate-y-1/2 z-10"><i class="bi bi-chevron-right rounded"></i></button>
        </div>
        <div class="maisVendidos mt-10">
            <h1>Mais vendidos</h1>
            <div class="carrossel-maisVendidos flex gap-10 overflow-x-auto">
                <button><i class="bi bi-chevron-left"></i></button>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                    <div class="bg-white w-[250px] h-[350px] rounded"></div>
                <button><i class="bi bi-chevron-right rounded"></i></button>
            </div>
        </div>
        <div class="lancamentos mt-10 ">
            <h1>Lançamentos</h1>
            <div class="carrossel-lancamentos flex gap-10 overflow-x-auto">
                <button><i class="bi bi-chevron-left"></i></button>
                <div class="bg-white w-[250px] h-[350px] rounded"></div>
                <div class="bg-white w-[250px] h-[350px] rounded"></div>
                <div class="bg-white w-[250px] h-[350px] rounded"></div>
                <div class="bg-white w-[250px] h-[350px] rounded"></div>
                <button><i class="bi bi-chevron-right rounded"></i></button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/landing-page.js') }}"></script>

@endsection
