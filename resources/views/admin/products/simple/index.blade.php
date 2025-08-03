@extends('layouts.admin')

@section('content')
<x-module-header title="Produtos Simples" description="Gerencie os produtos simples do sistema." />

@if(session('success'))
    <x-alert type="success" class="mb-6">
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="error" class="mb-6">
        {{ session('error') }}
    </x-alert>
@endif

@if($errors->any())
    <x-alert type="error" class="mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Lista de Produtos Simples</h2>
            <a href="{{ route('products.simple.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Cadastrar Produto
            </a>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="p-8 text-center">
            <div class="text-gray-500 mb-4">
                <i data-lucide="package" class="w-16 h-16 mx-auto mb-2"></i>
                <h3 class="text-lg font-medium">Nenhum produto encontrado</h3>
            </div>
            <p class="text-gray-600 mb-4">Não há produtos simples cadastrados no sistema.</p>
            <a href="{{ route('products.simple.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Criar primeiro produto
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nome
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Preço de Custo
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Preço de Venda
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Criado em
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                R$ {{ number_format($product->cost_price, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                R$ {{ number_format($product->sale_price, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.simple.edit', $product->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $product->id }})" 
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.simple.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
function confirmDelete(productId) {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
        document.getElementById('delete-form-' + productId).submit();
    }
}
</script>
@endsection
