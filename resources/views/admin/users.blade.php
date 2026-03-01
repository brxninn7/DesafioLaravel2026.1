@extends('layouts.main')

@section('content')
<div class="min-h-screen py-10 px-4 text-white">
    <div class="max-w-7xl mx-auto bg-white text-black p-8 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gerenciamento de Usuários</h1>
            <a href="{{ route('admin.users.create') }}" class="bg-[#161A24] text-white px-4 py-2 rounded shadow hover:bg-black transition-all">
                <i class="bi bi-plus-lg"></i> Novo Usuário
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="py-4 px-2">Nome</th>
                        <th class="py-4 px-2">E-mail</th>
                        <th class="py-4 px-2 italic">Telefone</th>
                        <th class="py-4 px-2">Cidade/UF</th> 
                        <th class="py-4 px-2 text-center">Tipo</th>
                        <th class="py-4 px-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-2 font-semibold">{{ $user->name }}</td>
                        <td class="py-4 px-2 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="py-4 px-2 text-sm italic">{{ $user->telefone ?? 'Não cadastrado' }}</td>
                        <td class="py-4 px-2 text-sm">
                            @php
                                $address = $user->addresses instanceof \Illuminate\Database\Eloquent\Collection 
                                    ? $user->addresses->first() 
                                    : $user->addresses;
                            @endphp
                            @if($address)
                                {{ $address->cidade }} / {{ $address->estato }}
                            @else
                                <span class="text-gray-400 italic">- / -</span>
                            @endif
                        </td>
                        <td class="py-4 px-2 text-center">
                            @if($user->is_admin)
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">Admin</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">Cliente</span>
                            @endif
                        </td>
                        <td class="py-4 px-2">
                            <div class="flex justify-center items-center gap-2">
                                <button type="button" onclick="openEmailModal('{{ $user->id }}', '{{ $user->name }}')" class="text-blue-500 hover:text-blue-700 text-lg transition-transform hover:scale-110" title="Enviar E-mail">
                                    <i class="bi bi-envelope-fill"></i>
                                </button>

                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700 text-lg transition-transform hover:scale-110" title="Visualizar">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 text-lg transition-transform hover:scale-110" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg transition-transform hover:scale-110" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>

<div id="emailModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white border border-gray-200 rounded-lg max-w-lg w-full p-8 shadow-2xl text-black">
            <h2 class="text-xl font-bold text-gray-950 mb-6 italic uppercase tracking-tight">Enviar Email para: <span id="modalUserName" class="text-[#161A24] border-b-2 border-gray-200"></span></h2>
            
            <form id="emailForm" method="POST" action="">
                @csrf
                <div class="mb-5">
                    <label class="block text-gray-700 text-[10px] font-black uppercase mb-2 tracking-widest">Assunto</label>
                    <input type="text" name="assunto" required class="w-full bg-white border border-gray-300 text-gray-900 rounded p-2.5 focus:border-[#161A24] focus:ring-1 focus:ring-[#161A24] outline-none transition-colors shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-[10px] font-black uppercase mb-2 tracking-widest">Mensagem</label>
                    <textarea name="mensagem" rows="5" required class="w-full bg-white border border-gray-300 text-gray-900 rounded p-2.5 focus:border-[#161A24] focus:ring-1 focus:ring-[#161A24] outline-none transition-colors shadow-sm"></textarea>
                </div>

                <div class="flex justify-end items-center gap-6">
                    <button type="button" onclick="closeEmailModal()" class="text-gray-400 hover:text-black uppercase text-[10px] font-black tracking-widest transition-colors">Cancelar</button>
                    <button type="submit" class="bg-[#161A24] hover:bg-black text-white font-black text-[10px] uppercase px-8 py-3 rounded shadow-md hover:shadow-xl transition-all">
                        Enviar Agora
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEmailModal(userId, userName) {
        const modal = document.getElementById('emailModal');
        const form = document.getElementById('emailForm');
        const nameSpan = document.getElementById('modalUserName');

        form.action = `/admin/users/${userId}/send-email`;
        nameSpan.innerText = userName;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEmailModal() {
        const modal = document.getElementById('emailModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('emailModal');
        if (event.target == modal) {
            closeEmailModal();
        }
    }
</script>
@endsection