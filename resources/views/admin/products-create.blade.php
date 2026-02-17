@extends('layouts.main')

@section('title', 'Cadastrar Produto')

@section('content')

<div class="flex justify-center items-center min-h-screen py-12 bg-gray-900">

    <div class="w-full max-w-md p-10 bg-white rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-8 text-black border-b pb-4">Novo Produto</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col">
                <label class="text-xs text-gray-500 uppercase font-bold mb-1">Fotos do Produto</label>
                <input type="file" name="fotos[]" multiple class="border p-3 rounded text-black" accept="image/*">
            </div>

        </form>
        
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="grid gap-6 text-black"> 
                <div class="flex flex-col">
                    <label class="text-xs text-gray-500 uppercase font-bold mb-1">Título</label>
                    <input type="text" name="titulo" placeholder="Título do Produto" class="border p-3 rounded bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500 uppercase font-bold mb-1">Descrição</label>
                    <textarea name="descricao" placeholder="Descrição detalhada" class="border p-3 rounded bg-white text-black h-32 focus:ring-2 focus:ring-blue-500 outline-none" required></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-500 uppercase font-bold mb-1">Preço</label>
                        <input type="number" step="0.01" name="preco" placeholder="R$ 0,00" class="border p-3 rounded bg-white text-black" required>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-500 uppercase font-bold mb-1">Estoque</label>
                        <input type="number" name="estoque" placeholder="Qtd" class="border p-3 rounded bg-white text-black" required>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500 uppercase font-bold mb-1">Marca</label>
                    <input type="text" name="marca" placeholder="Ex: Razer, Logitech..." class="border p-3 rounded bg-white text-black" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-500 uppercase font-bold mb-1">Categoria</label>
                        <select name="categoria" class="border p-3 rounded bg-white text-black cursor-pointer" required>
                            <option value="Teclado">Teclado</option>
                            <option value="Mouse">Mouse</option>
                            <option value="GPU">GPU</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs text-gray-500 uppercase font-bold mb-1">Tipo</label>
                        <input type="text" name="tipo" placeholder="Ex: Mecânico, Wireless" class="border p-3 rounded bg-white text-black" required>
                    </div>
                </div>
                
                <button type="submit" class="bg-[#161A24] text-white py-4 rounded font-bold hover:bg-black transition mt-4 shadow-md flex items-center justify-center gap-2">
                   <i class="bi bi-plus-lg"></i> CADASTRAR PRODUTO
                </button>
            </div>
        </form>
    </div>
</div>
@endsection