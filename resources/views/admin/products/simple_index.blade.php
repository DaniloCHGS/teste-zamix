@extends('layouts.admin')

@section('content')
    <x-module-header title="Produtos" />
    <div class="bg-white shadow rounded-lg p-6 w-full">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Lista de Produtos</h2>
            <a href="{{route("products.simple.create")}}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Cadastrar Produto</a>
        </div>

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nome</th>
                    <th class="py-2 px-4 border-b">Preço de Custo</th>
                    <th class="py-2 px-4 border-b">Preço de Venda</th>
                    <th class="py-2 px-4 border-b">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                        <td class="py-2 px-4 border-b">R$ {{ number_format($product->cost_price, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">R$ {{ number_format($product->sale_price, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('products.simple.edit', $product->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            <a href="{{ route('products.simple.destroy', $product->id) }}" class="text-red-600 hover:underline ml-2"
                               onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();">
                                Excluir
                            </a>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.simple.destroy', $product->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
                {{-- Adicione mais exemplos conforme necessário --}}
            </tbody>
        </table>
    </div>
@endsection
