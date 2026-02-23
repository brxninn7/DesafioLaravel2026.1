@extends('layouts.main')

@section('title', 'Editar Produto')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-black">Editar Produto</h1>

        <form action="{{ route('products.update', $produto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium text-gray-700">Título</label>
                    <input type="text" name="titulo" value="{{ $produto->titulo }}" class="w-full border-gray-300 rounded-md shadow-sm text-black" required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Tipo</label>
                    <select name="tipo" class="w-full border-gray-300 rounded-md shadow-sm text-black" required>
                        <option value="Hardware" {{ $produto->tipo == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="Periférico" {{ $produto->tipo == 'Periférico' ? 'selected' : '' }}>Periférico</option>
                        <option value="Computador" {{ $produto->tipo == 'Computador' ? 'selected' : '' }}>Computador</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Marca</label>
                    <input type="text" name="marca" value="{{ $produto->marca }}" class="w-full border-gray-300 rounded-md shadow-sm text-black">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" value="{{ $produto->preco }}" class="w-full border-gray-300 rounded-md shadow-sm text-black" required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Estoque</label>
                    <input type="number" name="estoque" value="{{ $produto->estoque }}" class="w-full border-gray-300 rounded-md shadow-sm text-black" required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Categoria</label>
                    <input type="text" name="categoria" value="{{ $produto->categoria }}" class="w-full border-gray-300 rounded-md shadow-sm text-black">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700">Descrição</label>
                    <textarea name="descricao" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-black" required>{{ $produto->descricao }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Salvar Alterações</button>
                <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-6 py-2 rounded font-bold hover:bg-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection