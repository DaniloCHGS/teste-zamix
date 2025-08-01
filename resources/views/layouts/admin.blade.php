@extends('layouts.app')

@section('body_content')
    <!-- Topbar -->
    <header class="bg-white shadow px-4 py-3 flex items-center justify-between">
        <div class="text-xl font-bold text-gray-800">Dashboard</div>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:underline bg-transparent border-none cursor-pointer">Sair</button>
            </form>
        </div>
    </header>
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-gray-100 border-r p-6 space-y-4">
            <nav class="space-y-2" aria-label="Sidebar navigation">
                <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('dashboard') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    Início
                </a>
                <a href="{{ route('users.index') }}"
                class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('users.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    Usuários
                </a>
                <a href="{{ route('products.simple.index') }}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.simple.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                     Produtos Simples
                </a>
                <a href="{{route("products.composite.index")}}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.composite.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                     Produtos Composto
                </a>
                <a href="{{ route('stocks.index') }}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('stocks.*') || request()->routeIs('stock_movements.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                     Estoque
                </a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50">
            <div class="">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- Mobile Sidebar -->
    <nav class="md:hidden bg-gray-100 border-t flex justify-around py-2" aria-label="Mobile sidebar navigation">
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Início</a>
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Perfil</a>
        <a href="#" class="px-3 py-2 rounded text-gray-700 hover:bg-blue-50">Configurações</a>
    </nav>
@endsection