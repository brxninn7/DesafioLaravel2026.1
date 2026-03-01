<section>
    <header>
        <h2 class="text-lg font-bold text-black">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="photo" :value="__('Foto de Perfil')" class="text-gray-700 font-bold uppercase text-xs" />
            @if($user->photo)
                <div class="mt-2 mb-4">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de {{ $user->name }}" class="h-20 w-20 rounded-full object-cover border border-gray-300">
                </div>
            @endif
            <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-500" />
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-bold uppercase text-xs" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full !bg-white !text-black border-gray-300" :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold uppercase text-xs" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full !bg-white !text-black border-gray-300" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="cpf" :value="__('CPF')" class="text-gray-700 font-bold uppercase text-xs" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full !bg-white !text-black border-gray-300" :value="old('cpf', $user->cpf)" />
            <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="phone" :value="__('Telefone')" class="text-gray-700 font-bold uppercase text-xs" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full !bg-white !text-black border-gray-300" :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div>
                <x-input-label for="date_of_birth" :value="__('Data de Nascimento')" class="text-gray-700 font-bold uppercase text-xs" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full !bg-white !text-black border-gray-300" :value="old('date_of_birth', $user->date_of_birth)" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="!bg-[#161A24] hover:!bg-black !text-white transition-all">{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>