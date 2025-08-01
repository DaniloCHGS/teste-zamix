@extends('layouts.admin')

@section('content')
    <x-module-header title="Produtos Compostos" description="Lista de produtos compostos cadastrados." />
   

    <x-card class="mx-auto">
     <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Lista de Produtos</h2>
            <a href="{{ route('products.composite.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Cadastrar Novo
            </a>
        </div>
     
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nome</th>
                    <th class="py-2 px-4 border-b">Preço de Venda</th>
                    <th class="py-2 px-4 border-b">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($compositeProducts as $product)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                        <td class="py-2 px-4 border-b">R$ {{ number_format($product->sale_price, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('products.composite.edit', $product) }}" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="{{ route('products.composite.delete', $product) }}" class="text-red-600 hover:underline">Excluir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">Nenhum produto composto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
@endsection