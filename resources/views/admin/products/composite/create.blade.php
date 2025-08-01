@extends('layouts.admin')

@section('content')
    <x-module-header title="Cadastrar Produto Composto" description="Preencha os dados para cadastrar um novo produto composto." />
    <x-card class="mx-auto">
        <form method="POST" action="{{route('products.composite.store')}}">
            @csrf
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="name" class="block text-gray-700 font-semibold">Nome</label>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="sale_price" class="block text-gray-700 font-semibold">Preço de Venda</label>
                    @error('sale_price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price') }}"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Componentes do Produto</h3>
                @error('items')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                <div id="components-container" class="space-y-4">
                    @foreach ($simpleProducts as $product)
                        <div class="component-item flex items-center justify-between p-4 border rounded bg-gray-50"
                            data-id="{{ $product->id }}">
                            <div class="flex items-center">
                                <input type="checkbox" name="items[{{ $product->id }}][id]" value="{{ $product->id }}"
                                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 component-checkbox">
                                <label for="product_{{ $product->id }}"
                                    class="ml-3 text-gray-700 font-semibold">{{ $product->name }}</label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-600">R$ {{ number_format($product->sale_price, 2, ',', '.') }}</span>
                                <input type="number" name="items[{{ $product->id }}][quantity]"
                                    class="w-24 px-3 py-2 border rounded component-quantity" min="1" value="1"
                                    disabled>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cadastrar</button>
            <a href="#" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
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