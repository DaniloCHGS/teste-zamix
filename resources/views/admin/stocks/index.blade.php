@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Estoque de Produtos Simples</h1>

    <div class="mb-4 flex justify-end space-x-2">
        <a href="{{ route('stock_movements.create_entrada') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Registrar Entrada
        </a>
        <a href="{{ route('stock_movements.create_saida') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Registrar Saída
        </a>
        <a href="{{ route('stock_movements.historico') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Histórico de Movimentações
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Produto
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Quantidade em Estoque
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $stock->product->name }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $stock->quantity }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                        Nenhum produto em estoque encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
