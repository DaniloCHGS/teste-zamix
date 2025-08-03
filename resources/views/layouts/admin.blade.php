@extends('layouts.app')

@section('body_content')
    <!-- Topbar -->
    <header class="bg-white shadow px-4 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden mr-3 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="text-xl font-bold text-gray-800">Dashboard</div>
        </div>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:underline bg-transparent border-none cursor-pointer">Sair</button>
            </form>
        </div>
    </header>
    
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar" class="hidden md:block w-64 bg-gray-100 border-r p-6 space-y-4">
            <nav class="space-y-2" aria-label="Sidebar navigation">
                <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Início
                    </div>
                </a>
                
                <a href="{{ route('users.index') }}"
                class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Usuários
                    </div>
                </a>
                
                <!-- Produtos Dropdown -->
                <div class="relative">
                    <button id="products-dropdown" class="w-full text-left px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('products.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Produtos
                            </div>
                            <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="products-dropdown-menu" class="hidden absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                        <a href="{{ route('products.simple.index') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.simple.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            Produtos Simples
                        </a>
                        <a href="{{ route('products.composite.index') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.composite.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                            Produtos Compostos
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('stocks.index') }}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('stocks.*') || request()->routeIs('stock_movements.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                        </svg>
                        Estoque
                    </div>
                </a>
                
                <a href="{{ route('requests.index') }}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('requests.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Requisições
                    </div>
                </a>
                
                <a href="{{ route('reports.index') }}"
                    class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 transition-colors {{ request()->routeIs('reports.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Relatórios
                    </div>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden"></div>
    
    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-100 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
            <button id="close-mobile-menu" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('dashboard') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Início
            </a>
            <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('users.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Usuários
            </a>
            <a href="{{ route('products.simple.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.simple.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Produtos Simples
            </a>
            <a href="{{ route('products.composite.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.composite.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Produtos Compostos
            </a>
            <a href="{{ route('stocks.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('stocks.*') || request()->routeIs('stock_movements.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Estoque
            </a>
            <a href="{{ route('requests.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('requests.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Requisições
            </a>
            <a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded text-gray-700 hover:bg-blue-50 {{ request()->routeIs('reports.*') ? 'bg-blue-100 font-bold text-blue-700' : '' }}">
                Relatórios
            </a>
        </nav>
    </aside>

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');
        
        function openMobileMenu() {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenuFunc() {
            mobileSidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
        
        mobileMenuButton.addEventListener('click', openMobileMenu);
        closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
        mobileOverlay.addEventListener('click', closeMobileMenuFunc);
        
        // Products dropdown functionality
        const productsDropdown = document.getElementById('products-dropdown');
        const productsDropdownMenu = document.getElementById('products-dropdown-menu');
        const dropdownArrow = productsDropdown.querySelector('svg:last-child');
        
        productsDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const isOpen = !productsDropdownMenu.classList.contains('hidden');
            
            if (isOpen) {
                productsDropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');
            } else {
                productsDropdownMenu.classList.remove('hidden');
                dropdownArrow.classList.add('rotate-180');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!productsDropdown.contains(e.target)) {
                productsDropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');
            }
        });
    </script>
@endsection