<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciamento de Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-[#161A24] to-[#121316] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-8">
                
                <header class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-black uppercase">Novo Usuário</h2>
                    <p class="text-sm text-gray-500">Cadastre um novo acesso ao sistema.</p>
                </header>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 text-xs font-black text-gray-400 uppercase tracking-widest">Dados da Conta</div>
                        
                        <div>
                            <x-input-label for="name" value="Nome Completo" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input id="name" name="name" type="text" class="block w-full !bg-white !text-black border-gray-300 h-10 shadow-sm" required />
                        </div>

                        <div>
                            <x-input-label for="email" value="E-mail" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input id="email" name="email" type="email" class="block w-full !bg-white !text-black border-gray-300 h-10 shadow-sm" required />
                        </div>

                        <div>
                            <x-input-label for="password" value="Senha" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input id="password" name="password" type="password" class="block w-full !bg-white !text-black border-gray-300 h-10 shadow-sm" required />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Confirmar Senha" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full !bg-white !text-black border-gray-300 h-10 shadow-sm" required />
                        </div>

                        <div class="flex items-center gap-2 md:col-span-2">
                            <input type="checkbox" name="is_admin" id="is_admin" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="is_admin" class="text-sm font-bold text-gray-700 uppercase tracking-tighter">Definir como Administrador</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-6 border-t border-gray-100">
                        <div class="md:col-span-4 text-xs font-black text-gray-400 uppercase tracking-widest">Endereço Principal</div>

                        <div class="md:col-span-1">
                            <x-input-label for="cep" value="CEP" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="cep" id="cep" placeholder="00000-000" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm" required />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label for="numero" value="Número" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="numero" id="numero" placeholder="Ex: 123" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="logradouro" value="Logradouro" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="logradouro" id="logradouro" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="bairro" value="Bairro" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="bairro" id="bairro" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm" required />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label for="cidade" value="Cidade" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="cidade" id="cidade" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm" required />
                        </div>
                        <div class="md:col-span-1">
                            <x-input-label for="estado" value="UF" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="estado" id="estado" class="!bg-white !text-black border-gray-300 w-full h-10 shadow-sm text-center" required />
                        </div>
                    </div>

                    <div class="pt-6 flex justify-between items-center">
                        <a href="{{ route('admin/users') }}" class="text-xs font-bold text-gray-500 hover:text-black uppercase">Voltar</a>
                        <button type="submit" class="bg-[#161A24] text-white font-bold py-3 px-10 rounded shadow hover:bg-black transition-all uppercase text-xs">
                            Salvar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`/api/cep/${cep}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            document.getElementById('cidade').value = data.localidade || ''; 
                            document.getElementById('estado').value = data.uf || '';         
                            document.getElementById('numero').focus();
                        }
                    });
            }
        });
    </script>
</x-app-layout>