<div class="bg-white w-[300px] h-[420px] rounded text-black p-4 flex-shrink-0 flex flex-col shadow-lg">
    <div class="imagem border border-gray-100 w-full h-[200px] rounded overflow-hidden flex items-center justify-center bg-gray-50">
        <img src="https://placehold.co/300x200?text={{ $produto->marca }}" alt="{{ $produto->titulo }}" class="object-contain w-full h-full">
    </div>
    <div class="informacoes mt-4 flex-grow">
        <h2 class="font-bold text-lg truncate">{{ $produto->titulo }}</h2>
        <p class="text-gray-500 text-sm mb-2">{{ $produto->marca }}</p>
        <p class="preco-pix text-[22px] text-blue-700">
            <strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
        </p>
    </div>
    <a href="{{ route('product.show', $produto->id) }}" class="bg-[#161A24] text-white text-center hover:bg-black p-[8px] w-full rounded mt-4 uppercase text-sm font-bold transition-colors">
        Comprar
    </a>
</div>