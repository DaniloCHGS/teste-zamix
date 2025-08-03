@extends('layouts.app')

@section('body_content')
    <!-- Topbar -->
    <header class="bg-white shadow-sm border-b border-gray-200 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden mr-3 text-gray-600 hover:text-gray-800 transition-colors">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <div class="text-xl font-bold text-gray-800">Dashboard</div>
        </div>
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 transition-colors bg-transparent border-none cursor-pointer">
                    <i data-lucide="log-out" class="w-4 h-4 inline mr-1"></i>
                    Sair
                </button>
            </form>
        </div>
    </header>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="hidden md:block w-64 bg-gradient-to-b from-blue-50 to-blue-100 border-r border-blue-200 flex-shrink-0">
            <div class="p-6 space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Sistema</span>
                </div>
                
                <nav class="space-y-2" aria-label="Sidebar navigation">
                    <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                        <i data-lucide="home" class="w-5 h-5 mr-3"></i>
                        Início
                    </a>
                    
                    <a href="{{ route('users.index') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                        <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                        Usuários
                    </a>
                    
                    <!-- Produtos Dropdown -->
                    <div class="relative">
                        <button id="products-dropdown" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                            <div class="flex items-center">
                                <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                                Produtos
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 transform transition-transform duration-200"></i>
                        </button>
                        <div id="products-dropdown-menu" class="hidden absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-10 overflow-hidden">
                            <a href="{{ route('products.simple.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.simple.*') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                                <i data-lucide="circle" class="w-3 h-3 mr-2"></i>
                                Produtos Simples
                            </a>
                            <a href="{{ route('products.composite.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ request()->routeIs('products.composite.*') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                                <i data-lucide="layers" class="w-3 h-3 mr-2"></i>
                                Produtos Compostos
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('stocks.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('stocks.*') || request()->routeIs('stock_movements.*') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                        <i data-lucide="warehouse" class="w-5 h-5 mr-3"></i>
                        Estoque
                    </a>
                    
                    <a href="{{ route('requests.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('requests.*') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                        <i data-lucide="clipboard-list" class="w-5 h-5 mr-3"></i>
                        Requisições
                    </a>
                    
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-200 text-blue-800 font-semibold shadow-sm' : '' }}">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <div class="flex-1 p-4 md:p-6 bg-gray-50 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden"></div>
    
    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-50 to-blue-100 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="flex items-center justify-between p-4 border-b border-blue-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="package" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-lg font-semibold text-gray-800">Sistema</span>
            </div>
            <button id="close-mobile-menu" class="text-gray-600 hover:text-gray-800 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="home" class="w-5 h-5 mr-3"></i>
                Início
            </a>
            <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                Usuários
            </a>
            <a href="{{ route('products.simple.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('products.simple.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="circle" class="w-5 h-5 mr-3"></i>
                Produtos Simples
            </a>
            <a href="{{ route('products.composite.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('products.composite.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="layers" class="w-5 h-5 mr-3"></i>
                Produtos Compostos
            </a>
            <a href="{{ route('stocks.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('stocks.*') || request()->routeIs('stock_movements.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="warehouse" class="w-5 h-5 mr-3"></i>
                Estoque
            </a>
            <a href="{{ route('requests.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('requests.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5 mr-3"></i>
                Requisições
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-200 hover:text-blue-800 transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-200 text-blue-800 font-semibold' : '' }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5 mr-3"></i>
                Relatórios
            </a>
        </nav>
    </aside>

    <!-- Lucide Icons Script -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
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
        const dropdownArrow = productsDropdown.querySelector('[data-lucide="chevron-down"]');
        
        productsDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const isOpen = !productsDropdownMenu.classList.contains('hidden');
            
            if (isOpen) {
                productsDropdownMenu.classList.add('hidden');
                dropdownArrow.style.transform = 'rotate(0deg)';
            } else {
                productsDropdownMenu.classList.remove('hidden');
                dropdownArrow.style.transform = 'rotate(180deg)';
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!productsDropdown.contains(e.target)) {
                productsDropdownMenu.classList.add('hidden');
                dropdownArrow.style.transform = 'rotate(0deg)';
            }
        });
    </script>
@endsection