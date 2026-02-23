<nav x-data="{ open: false }" class="bg-white dark:bg-gradient-to-b from-[#121316] to-[#161A24] border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>

            <div class="flex items-center m-2">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="w-[300px] lg:w-[600px] rounded text-black text-[14px] border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                        placeholder="Pesquise um produto ou marca...">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md dark:text-gray-400 bg-white dark:bg-transparent hover:text-zinc-100 focus:outline-none transition">
                                <div class="bg-white w-[35px] h-[35px] mr-2 rounded-full items-center content-center text-[20px] text-black">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin/users')">
                                    {{ __('Usuários') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-gray-600"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium bg-white p-2 rounded text-black hover:bg-zinc-400 transition-colors">Entrar</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-white p-2 rounded text-black hover:bg-zinc-400 transition-colors">Cadastrar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>