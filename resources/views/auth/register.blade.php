<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" required />
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="telefone" :value="__('Telefone')" />
                <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" required />
            </div>
            <div>
                <x-input-label for="data_nascimento" :value="__('Data de Nascimento')" />
                <x-text-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" required />
            </div>
        </div>

        <div class="mt-4 p-4 bg-gray-800 rounded">
            <h3 class="text-white mb-2 text-sm font-bold">Endereço</h3>
            
            <div>
                <x-input-label for="cep" :value="__('CEP')" />
                <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" required />
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <div>
                    <x-input-label for="logradouro" :value="__('Logradouro')" />
                    <x-text-input id="logradouro" class="block mt-1 w-full bg-gray-700" type="text" name="logradouro" readonly />
                </div>
                <div>
                    <x-input-label for="bairro" :value="__('Bairro')" />
                    <x-text-input id="bairro" class="block mt-1 w-full bg-gray-700" type="text" name="bairro" readonly />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-2">
                <div>
                    <x-input-label for="cidade" :value="__('Cidade')" />
                    <x-text-input id="cidade" class="block mt-1 w-full bg-gray-700" type="text" name="cidade" readonly />
                </div>
                <div>
                    <x-input-label for="estado" :value="__('Estado')" />
                    <x-text-input id="estado" class="block mt-1 w-full bg-gray-700" type="text" name="estado" readonly />
                </div>
            </div>

            <div class="mt-2">
                <x-input-label for="numero" :value="__('Número')" />
                <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" required />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
    document.getElementById('cep').addEventListener('blur', function() {
        let cep = this.value.replace(/\D/g, '');
        
        if (cep.length === 8) {
            fetch(`/cep/${cep}`) 
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro || '';
                        document.getElementById('bairro').value = data.bairro || '';
                        document.getElementById('cidade').value = data.localidade || ''; 
                        document.getElementById('estado').value = data.uf || '';         
                        document.getElementById('numero').focus();
                    } else {
                        alert("CEP não encontrado.");
                    }
                })
                .catch(error => console.error('Erro na busca do CEP:', error));
        }
    });
    </script>
</x-guest-layout>