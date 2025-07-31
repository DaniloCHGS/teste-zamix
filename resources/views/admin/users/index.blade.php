@extends('layouts.admin')

@section('content')
<x-module-header title="Usuários" />
<div class="bg-white shadow rounded-lg p-6 w-full">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Lista de Usuários</h2>
        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Adicionar Usuário</a>
    </div>

    @if($users->isEmpty())
        <p class="text-gray-600">Nenhum usuário encontrado.</p>
    @else
        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nome</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }}">
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline ml-2">Excluir</button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    @endif
</div>
</div>
@endsection