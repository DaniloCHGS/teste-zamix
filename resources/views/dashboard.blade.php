@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Topbar -->
    <header class="bg-white shadow px-4 py-3 flex items-center justify-between">
        <div class="text-xl font-bold text-gray-800">Dashboard</div>
        <div>
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Sair</a>
        </div>
    </header>
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-gray-100 border-r p-6 space-y-4">
            <nav class="space-y-2">
                <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Início</a>
                <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Perfil</a>
                <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Configurações</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-2xl font-semibold text-gray-800 mb-4">Bem-vindo ao Dashboard!</h1>
                <p class="text-gray-600">Esta é uma página inicial simples e responsiva. Use o menu lateral para navegar.</p>
            </div>
        </main>
    </div>
    <!-- Mobile Sidebar -->
    <nav class="md:hidden bg-gray-100 border-t flex justify-around py-2">
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Início</a>
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Perfil</a>
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Configurações</a>
    </nav>
</div>
@endsection
