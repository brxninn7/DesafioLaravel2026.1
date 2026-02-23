@extends('layouts.main')

@section('title', $produto->titulo)

@section('content')
    <div class="min-h-screen py-10 px-4"> 
        <div class="bg-white text-black max-w-[850px] mx-auto rounded-lg p-6 shadow-2xl">
            <div class="produto flex flex-col md:flex-row gap-8">
                
                <div class="imagem flex flex-col items-center">
                    <div class="imagem-produto border border-gray-200 w-[350px] h-[350px] rounded-lg flex items-center justify-center bg-gray-50 overflow-hidden">
                        @if($produto->images->count() > 0)
                            <img src="{{ asset('storage/' . $produto->images->first()->image_path) }}" 
                                 id="main-photo" 
                                 alt="{{ $produto->titulo }}" 
                                 class="object-contain w-full h-full transition-opacity duration-300">
                        @else
                            <img src="https://placehold.co/400x400?text=Sem+Foto" class="object-contain w-full h-full">
                        @endif
                    </div>
                    
                    <div class="carrossel-imagem flex items-center mt-4 gap-2">
                        <button class="text-gray-400 hover:text-black"><i class="bi bi-chevron-left"></i></button>
                        <div class="flex gap-2 overflow-x-auto max-w-[250px] py-1">
                            @foreach($produto->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="w-12 h-12 border border-gray-200 rounded bg-gray-100 cursor-pointer hover:border-blue-500 transition-all"
                                     onclick="changePhoto(this.src)">
                            @endforeach
                        </div>
                        <button class="text-gray-400 hover:text-black"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>

                <div class="informacoes flex-grow">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">{{ $produto->marca }}</p>
                    <h1 class="text-3xl font-extrabold leading-tight mb-2">{{ $produto->titulo }}</h1>
                    
                    <div class="mb-6">
                        @if($produto->estoque > 0)
                            <span class="text-green-600 text-sm font-bold italic">Em estoque: {{ $produto->estoque }} unidades</span>
                        @else
                            <span class="text-red-500 text-sm font-bold italic">Produto esgotado</span>
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

                        @auth
                            @if(!Auth::user()->is_admin)
                                <form action="{{ route('products.buy', $produto->id) }}" method="POST" class="flex-grow">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full bg-[#161a24] text-white font-bold h-12 rounded hover:bg-black transition-all shadow-lg uppercase tracking-wider {{ $produto->estoque <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $produto->estoque <= 0 ? 'disabled' : '' }}>
                                        {{ $produto->estoque <= 0 ? 'Esgotado' : 'Comprar' }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex-grow flex items-center justify-center bg-[#161a24] text-white font-bold h-12 rounded hover:bg-black transition-all shadow-lg uppercase tracking-wider text-center">
                                Login para Comprar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 bg-gray-50 border rounded text-black">
                <h3 class="font-bold text-lg text-black mb-2">Informações do Anunciante</h3>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <p><strong>Nome:</strong> {{ $produto->user->name }}</p>
                    <p><strong>Telefone:</strong> {{ $produto->user->telefone }}</p>
                    <p><strong>Cidade:</strong> {{ $produto->user->cidade }} - {{ $produto->user->estado }}</p>
                    <p><strong>Membro desde:</strong> {{ $produto->user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100">
                <h3 class="text-lg font-bold">Descrição</h3>
                <hr class="border border-black-50 rounded mb-4">
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ $produto->descricao }}
                </p>
            </div>
        </div>
    </div>

    <script>
        function changePhoto(src) {
            const mainPhoto = document.getElementById('main-photo');
            if(mainPhoto) {
                mainPhoto.style.opacity = '0';
                setTimeout(() => {
                    mainPhoto.src = src;
                    mainPhoto.style.opacity = '1';
                }, 200);
            }
        }
    </script>
@endsection