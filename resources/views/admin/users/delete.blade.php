@extends('layouts.admin')

@section('content')
    <x-module-header title="Excluir Usuário" description="Confirme a exclusão do usuário abaixo." />
    <div class="bg-white shadow rounded-lg p-6 w-full max-w-lg mx-auto">
        <p class="mb-6">Tem certeza que deseja excluir o usuário <strong>{{ $user->name }}</strong>?</p>
        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmar Exclusão</button>
            <a href="{{ route('users.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
@endsection
