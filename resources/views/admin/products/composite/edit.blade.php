@extends('layouts.admin')

@section('content')
    <x-module-header title="Editar Produto Composto" description="Altere os dados do produto composto abaixo." />
    <x-card class="mx-auto">
        <form method="POST" action="#">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="name" class="block text-gray-700 font-semibold">Nome</label>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="cost_price" class="block text-gray-700 font-semibold">Preço de Custo</label>
                    @error('cost_price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="sale_price" class="block text-gray-700 font-semibold">Preço de Venda</label>
                    @error('sale_price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Componentes do Produto</h3>
                <div id="components-container">
                    @foreach($product->components as $index => $component)
                        <div class="component-item mb-4 p-4 border rounded bg-gray-50">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold">Componente #{{ $index + 1 }}</h4>
                                <button type="button" class="remove-component text-red-600 hover:text-red-800">Remover</button>
                            </div>
                            <div class="mb-2">
                                <label for="component_product_id_{{ $index }}" class="block text-gray-700">Produto:</label>
                                <select name="components[{{ $index }}][product_id]" id="component_product_id_{{ $index }}" class="w-full px-3 py-2 border rounded">
                                    <option value="">Selecione um produto</option>
                                    @foreach($simpleProducts as $simpleProduct)
                                        <option value="{{ $simpleProduct->id }}" {{ $simpleProduct->id == $component->product_id ? 'selected' : '' }}>{{ $simpleProduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="component_quantity_{{ $index }}" class="block text-gray-700">Quantidade:</label>
                                <input type="number" name="components[{{ $index }}][quantity]" id="component_quantity_{{ $index }}" class="w-full px-3 py-2 border rounded" min="1" value="{{ $component->quantity }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-component" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Adicionar Componente</button>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            <a href="#" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let componentCount = {{ count($product->components) }};
            const componentsContainer = document.getElementById('components-container');
            const addComponentButton = document.getElementById('add-component');

            // Add event listeners for existing remove buttons
            document.querySelectorAll('.remove-component').forEach(button => {
                button.addEventListener('click', function () {
                    button.closest('.component-item').remove();
                });
            });

            addComponentButton.addEventListener('click', function () {
                const newComponentIndex = componentCount++;
                const componentDiv = document.createElement('div');
                componentDiv.classList.add('component-item', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-50');
                componentDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-semibold">Componente #${newComponentIndex + 1}</h4>
                        <button type="button" class="remove-component text-red-600 hover:text-red-800">Remover</button>
                    </div>
                    <div class="mb-2">
                        <label for="component_product_id_${newComponentIndex}" class="block text-gray-700">Produto:</label>
                        <select name="components[${newComponentIndex}][product_id]" id="component_product_id_${newComponentIndex}" class="w-full px-3 py-2 border rounded">
                            <option value="">Selecione um produto</option>
                            @foreach($simpleProducts as $simpleProduct)
                                <option value="{{ $simpleProduct->id }}">{{ $simpleProduct->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="component_quantity_${newComponentIndex}" class="block text-gray-700">Quantidade:</label>
                        <input type="number" name="components[${newComponentIndex}][quantity]" id="component_quantity_${newComponentIndex}" class="w-full px-3 py-2 border rounded" min="1" value="1">
                    </div>
                `;
                componentsContainer.appendChild(componentDiv);

                componentDiv.querySelector('.remove-component').addEventListener('click', function () {
                    componentDiv.remove();
                });
            });
        });
    </script>
@endsection
