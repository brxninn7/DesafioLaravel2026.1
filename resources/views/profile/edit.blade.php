<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Sua Carteira
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Saldo disponível para compras no site.
                            </p>
                        </header>

                        <div class="mt-4 text-3xl font-bold text-green-600 dark:text-green-400">
                            R$ {{ number_format(auth()->user()->saldo, 2, ',', '.') }}
                        </div>

                        <form method="post" action="{{ route('profile.deposit') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="value" value="Adicionar Saldo" />
                                <x-text-input id="value" name="value" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.00" required />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Depositar</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>