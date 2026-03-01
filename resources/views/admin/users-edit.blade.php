@extends('layouts.main')

@section('content')
<div class="min-h-screen py-10 px-4">
    <div class="max-w-3xl mx-auto bg-white text-black p-8 rounded-lg shadow-2xl">
        <h1 class="text-2xl font-bold mb-6 border-b pb-4">Editar Usuário: {{ $user->name }}</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">Nome</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">Telefone</label>
                    <input type="text" name="telefone" value="{{ $user->telefone }}" class="w-full border p-2 rounded" placeholder="(00) 00000-0000">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase text-gray-400">Saldo Disponível (R$)</label>
                    <input type="number" step="0.01" name="saldo" value="{{ $user->saldo }}" class="w-full border p-2 rounded text-black font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">CEP</label>
                    <input type="text" id="cep" name="cep" value="{{ $user->addresses->first()->cep ?? '' }}" class="w-full border p-2 rounded" onblur="buscarCep(this.value)">
                </div>
                
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">UF / Estado</label>
                    <input type="text" id="estado" name="estado" value="{{ $user->addresses->first()->estato ?? '' }}" class="w-full border p-2 rounded bg-gray-50" readonly>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="{{ $user->addresses->first()->cidade ?? '' }}" class="w-full border p-2 rounded bg-gray-50" readonly>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">Bairro</label>
                    <input type="text" id="bairro" name="bairro" value="{{ $user->addresses->first()->bairro ?? '' }}" class="w-full border p-2 rounded">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase text-gray-400">Logradouro</label>
                    <input type="text" id="logradouro" name="logradouro" value="{{ $user->addresses->first()->logradouro ?? '' }}" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400">Número</label>
                    <input type="text" name="numero" value="{{ $user->addresses->first()->numero ?? '' }}" class="w-full border p-2 rounded" placeholder="Ex: 123 ou S/N">
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-[#161a24] text-white px-6 py-2 rounded font-bold hover:bg-black transition shadow-lg">
                    Salvar Alterações
                </button>
                <a href="{{ $user->is_admin ? route('admin.admins.index') : route('admin/users') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded font-bold hover:bg-gray-300 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function buscarCep(cep) {
    const cleanCep = cep.replace(/\D/g, '');
    if (cleanCep.length === 8) {
        fetch(`/api/cep/${cleanCep}`)
            .then(response => response.json())
            .then(data => {
                if(!data.erro) {
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                }
            })
            .catch(error => console.error('Erro:', error));
    }
}
</script>
@endsection