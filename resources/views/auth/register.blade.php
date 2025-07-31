@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-center text-gray-800">Cadastro</h2>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input id="name" name="name" type="text" required autofocus class="mt-1 block w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 bg-gray-50" />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 bg-gray-50" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 bg-gray-50" />
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Cadastrar</button>
            </div>
        </form>
        <div class="text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="hover:underline">Já tem conta? Entrar</a>
        </div>
    </div>
</div>
@endsection
