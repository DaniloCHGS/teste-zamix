@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Nova Requisição</h1>
        <p class="text-gray-600">Crie uma nova requisição de produtos.</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('requests.store') }}" method="POST" id="requestForm">
            @csrf

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Atribuir a:</label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('user_id') border-red-500 @enderror">
                    <option value="">Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="requested_at" class="block text-gray-700 text-sm font-bold mb-2">Data da Requisição:</label>
                <input type="date" name="requested_at" id="requested_at" value="{{ old('requested_at', date('Y-m-d')) }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('requested_at') border-red-500 @enderror">
                @error('requested_at')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Itens da Requisição</h3>
                
                @error('items')
                    <p class="text-red-500 text-xs italic mb-2">{{ $message }}</p>
                @enderror

                <div id="items-container">
                    <div class="item-row bg-gray-50 p-4 rounded mb-2 flex flex-wrap items-end">
                        <div class="w-full md:w-1/2 pr-2 mb-2 md:mb-0">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Produto:</label>
                            <select name="items[0][product_id]" class="product-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Selecione um produto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/4 pr-2 mb-2 md:mb-0">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Quantidade:</label>
                            <input type="number" name="items[0][quantity]" min="1" value="1" class="quantity-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="w-full md:w-1/4 flex items-center justify-end">
                            <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Remover
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Adicionar Item
                </button>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('requests.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Salvar Requisição
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsContainer = document.getElementById('items-container');
            const addItemButton = document.getElementById('add-item');
            let itemCount = 1;

            // Adicionar item
            addItemButton.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'item-row bg-gray-50 p-4 rounded mb-2 flex flex-wrap items-end';
                newItem.innerHTML = `
                    <div class="w-full md:w-1/2 pr-2 mb-2 md:mb-0">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Produto:</label>
                        <select name="items[${itemCount}][product_id]" class="product-select shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4 pr-2 mb-2 md:mb-0">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Quantidade:</label>
                        <input type="number" name="items[${itemCount}][quantity]" min="1" value="1" class="quantity-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="w-full md:w-1/4 flex items-center justify-end">
                        <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Remover
                        </button>
                    </div>
                `;
                itemsContainer.appendChild(newItem);
                itemCount++;

                // Adicionar evento de remoção ao novo botão
                const removeButton = newItem.querySelector('.remove-item');
                removeButton.addEventListener('click', function() {
                    newItem.remove();
                });
            });

            // Configurar evento de remoção para o primeiro item
            const firstRemoveButton = document.querySelector('.remove-item');
            if (firstRemoveButton) {
                firstRemoveButton.addEventListener('click', function() {
                    if (itemsContainer.querySelectorAll('.item-row').length > 1) {
                        this.closest('.item-row').remove();
                    } else {
                        alert('A requisição deve ter pelo menos um item.');
                    }
                });
            }

            // Validar formulário antes de enviar
            document.getElementById('requestForm').addEventListener('submit', function(e) {
                const productSelects = document.querySelectorAll('.product-select');
                let valid = true;

                productSelects.forEach(select => {
                    if (!select.value) {
                        valid = false;
                        select.classList.add('border-red-500');
                    } else {
                        select.classList.remove('border-red-500');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Por favor, selecione um produto para cada item.');
                }
            });
        });
    </script>
@endsection