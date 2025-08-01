@extends('layouts.admin')

@section('content')
    <x-module-header title="Editar Produto Composto" description="Atualize os dados do produto composto." />
    <x-card class="mx-auto">
        <form method="POST" action="{{ route('products.composite.update', $product) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="name" class="block text-gray-700 font-semibold">Nome</label>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="sale_price" class="block text-gray-700 font-semibold">Preço de Venda</label>
                    @error('sale_price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Componentes do Produto</h3>
                @error('items')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                <div id="components-container" class="space-y-4">
                    @foreach ($simpleProducts as $simpleProduct)
                        @php
                            $isChecked = isset($selectedComponents[$simpleProduct->id]);
                            $quantity = $selectedComponents[$simpleProduct->id] ?? 1;
                        @endphp
                        <div class="component-item flex items-center justify-between p-4 border rounded bg-gray-50"
                            data-id="{{ $simpleProduct->id }}">
                            <div class="flex items-center">
                                <input type="checkbox" name="items[{{ $simpleProduct->id }}][id]" value="{{ $simpleProduct->id }}"
                                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 component-checkbox"
                                    {{ $isChecked ? 'checked' : '' }}>
                                <label for="product_{{ $simpleProduct->id }}"
                                    class="ml-3 text-gray-700 font-semibold">{{ $simpleProduct->name }}</label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-600">R$ {{ number_format($simpleProduct->sale_price, 2, ',', '.') }}</span>
                                <input type="number" name="items[{{ $simpleProduct->id }}][quantity]"
                                    class="w-24 px-3 py-2 border rounded component-quantity" min="1" value="{{ $quantity }}"
                                    {{ !$isChecked ? 'disabled' : '' }}>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Atualizar</button>
            <a href="{{ route('products.composite.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const componentsContainer = document.getElementById('components-container');

            componentsContainer.addEventListener('change', function(event) {
                if (event.target.classList.contains('component-checkbox')) {
                    const componentItem = event.target.closest('.component-item');
                    const quantityInput = componentItem.querySelector('.component-quantity');
                    quantityInput.disabled = !event.target.checked;
                }
            });
        });
    </script>
@endsection