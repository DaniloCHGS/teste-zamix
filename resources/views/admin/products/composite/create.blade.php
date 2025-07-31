@extends('layouts.admin')

@section('content')
    <x-module-header title="Cadastrar Produto Composto" description="Preencha os dados para cadastrar um novo produto composto." />
    <x-card class="mx-auto">
        <form method="POST" action="#">
            @csrf
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="name" class="block text-gray-700 font-semibold">Nome</label>
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label for="sale_price" class="block text-gray-700 font-semibold">Preço de Venda</label>
                    @error('sale_price')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Componentes do Produto</h3>
                <div id="components-container">
                    {{-- Componentes serão adicionados aqui via JavaScript --}}
                </div>
                <button type="button" id="add-component" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Adicionar Componente</button>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cadastrar</button>
            <a href="#" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let componentCount = 0;
            const componentsContainer = document.getElementById('components-container');
            const addComponentButton = document.getElementById('add-component');

            // Mocked simple products data
            const simpleProducts = [
                { id: 1, name: 'Produto Simples A' },
                { id: 2, name: 'Produto Simples B' },
                { id: 3, name: 'Produto Simples C' },
            ];

            addComponentButton.addEventListener('click', function () {
                componentCount++;
                const componentDiv = document.createElement('div');
                componentDiv.classList.add('component-item', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-50');
                componentDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-semibold">Componente #${componentCount}</h4>
                        <button type="button" class="remove-component text-red-600 hover:text-red-800">Remover</button>
                    </div>
                    <div class="mb-2">
                        <label for="component_product_id_${componentCount}" class="block text-gray-700">Produto:</label>
                        <select name="components[${componentCount}][product_id]" id="component_product_id_${componentCount}" class="w-full px-3 py-2 border rounded">
                            <option value="">Selecione um produto</option>
                            ${simpleProducts.map(product => `<option value="${product.id}">${product.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="component_quantity_${componentCount}" class="block text-gray-700">Quantidade:</label>
                        <input type="number" name="components[${componentCount}][quantity]" id="component_quantity_${componentCount}" class="w-full px-3 py-2 border rounded" min="1" value="1">
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
