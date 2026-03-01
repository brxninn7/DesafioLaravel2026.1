<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-[#161A24] to-[#121316] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-bold text-black">Sua Carteira</h2>
                            <p class="mt-1 text-sm text-gray-500">Saldo disponível para compras no site.</p>
                        </header>

                        <div class="mt-4 text-4xl font-black text-green-600">
                            R$ {{ number_format(auth()->user()->saldo, 2, ',', '.') }}
                        </div>

                        <form method="post" action="{{ route('profile.deposit') }}" class="mt-6 flex items-end gap-4">
                            @csrf
                            <div class="w-1/2">
                                <x-input-label for="value" value="Adicionar Saldo" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input id="value" name="value" type="number" step="0.01"
                                    class="block w-full !bg-white !text-black border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm h-10" placeholder="0.00" required />
                            </div>
                            <x-primary-button class="!bg-[#161A24] hover:!bg-black !text-white h-10 transition-all">
                                Depositar
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl text-black">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-bold text-black">Meus Endereços</h2>
                    <p class="mt-1 text-sm text-gray-500">Gerencie seus locais de entrega e cobrança.</p>
                </header>

                <div class="space-y-3 mb-8">
                    @forelse ($user->addresses ?? [] as $address)
                        <div class="p-4 border border-gray-100 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="text-gray-800 text-sm">
                                <span class="font-bold text-black">{{ $address->logradouro }}, {{ $address->numero }}</span><br>
                                <span class="text-gray-500">{{ $address->bairro }} — {{ $address->cidade }}/{{ $address->estato }} ({{ $address->cep }})</span>
                            </div>
                            <form method="POST" action="{{ route('address.destroy', $address->id) }}" class="m-0">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-tighter">Remover</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic">Nenhum endereço cadastrado.</p>
                    @endforelse
                </div>

                <div class="mt-10 border-t border-gray-100 pt-8">
                    <h3 class="text-black mb-6 text-xs font-bold uppercase tracking-widest">Adicionar Novo Endereço</h3>
                    
                    <form method="POST" action="{{ route('address.store') }}" class="max-w-2xl space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-1">
                                <x-input-label for="cep" value="CEP" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input name="cep" id="cep" placeholder="00000-000" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10" />
                            </div>
                            <div class="md:col-span-1">
                                <x-input-label for="numero" value="Número" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input name="numero" id="numero" placeholder="Ex: 123" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="logradouro" value="Logradouro" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                            <x-text-input name="logradouro" id="logradouro" placeholder="Nome da rua ou avenida" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-2">
                                <x-input-label for="bairro" value="Bairro" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input name="bairro" id="bairro" placeholder="Bairro" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="cidade" value="Cidade" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input name="cidade" id="cidade" placeholder="Cidade" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10" />
                            </div>
                            <div class="md:col-span-1">
                                <x-input-label for="estado" value="UF" class="text-gray-700 font-bold uppercase text-[10px] mb-1" />
                                <x-text-input name="estado" id="estado" placeholder="UF" class="!bg-white !text-black border-gray-300 rounded-md shadow-sm w-full h-10 text-center" />
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button class="bg-[#161A24] text-white font-bold py-2 px-8 rounded shadow hover:bg-black transition-all uppercase text-xs">
                                Salvar Endereço
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg text-black">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-6 bg-white border border-red-100 shadow sm:rounded-lg text-black">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>