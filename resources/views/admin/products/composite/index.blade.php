@extends('layouts.admin')

@section('content')
<x-module-header title="Produtos Compostos" description="Gerencie os produtos compostos do sistema." />

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
            <h2 class="text-lg font-semibold text-gray-800">Lista de Produtos Compostos</h2>
            <a href="{{ route('products.composite.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Cadastrar Produto Composto
            </a>
        </div>
    </div>

    @if($compositeProducts->isEmpty())
        <div class="p-8 text-center">
            <div class="text-gray-500 mb-4">
                <i data-lucide="layers" class="w-16 h-16 mx-auto mb-2"></i>
                <h3 class="text-lg font-medium">Nenhum produto composto encontrado</h3>
            </div>
            <p class="text-gray-600 mb-4">Não há produtos compostos cadastrados no sistema.</p>
            <a href="{{ route('products.composite.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Criar primeiro produto composto
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
                            Preço de Venda
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Componentes
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
                    @foreach($compositeProducts as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                R$ {{ number_format($product->sale_price, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="space-y-1">
                                    @foreach($product->components as $component)
                                        <div class="flex items-center text-xs">
                                            <span class="font-medium">{{ $component->name }}</span>
                                            <span class="text-gray-400 mx-1">×</span>
                                            <span>{{ $component->pivot->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.composite.edit', $product) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('products.composite.delete', $product) }}" 
                                       class="text-red-600 hover:text-red-900 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection