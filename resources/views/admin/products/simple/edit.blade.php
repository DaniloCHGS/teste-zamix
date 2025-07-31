@extends('layouts.admin')

@section('content')
    <x-module-header title="Editar Produto Simples" description="Altere os dados do produto abaixo." />
    <x-card class="mx-auto">
        <form method="POST" action="{{ route('products.simple.update', $product->id) }}">
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
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            <a href="{{ route('products.simple.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>
@endsection
