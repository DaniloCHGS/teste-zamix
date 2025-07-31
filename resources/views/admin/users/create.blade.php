@extends('layouts.admin')

@section('content')
    <x-module-header title="Adicionar Usuário" description="Preencha os dados para cadastrar um novo usuário." />
    <div class="bg-white shadow rounded-lg p-6 w-full max-w-lg mx-auto">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="name" class="block text-gray-700 font-semibold">Nome</label>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-gray-700 font-semibold">Senha</label>
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cadastrar</button>
            <a href="{{ route('users.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
@endsection
