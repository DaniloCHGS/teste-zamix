@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Relatório de Entrada de Estoque</h1>
        <p class="text-gray-600">Filtre as entradas de estoque por período.</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('reports.stock_entry') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Início:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Fim:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(isset($movements))
        <div class="bg-white shadow-md rounded-lg p-6">
            @if($movements->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Custo Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Venda Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $grandTotalCost = 0;
                            $grandTotalSale = 0;
                        @endphp
                        @foreach($movements as $movement)
                            @php
                                $totalCost = $movement->quantity * $movement->product->cost_price;
                                $totalSale = $movement->quantity * $movement->product->sale_price;
                                $grandTotalCost += $totalCost;
                                $grandTotalSale += $totalSale;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $movement->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $movement->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">R$ {{ number_format($totalCost, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">R$ {{ number_format($totalSale, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="2" class="px-6 py-3 text-right text-sm font-bold text-gray-700">Total</td>
                            <td class="px-6 py-3 text-left text-sm font-bold text-gray-700">R$ {{ number_format($grandTotalCost, 2, ',', '.') }}</td>
                            <td class="px-6 py-3 text-left text-sm font-bold text-gray-700">R$ {{ number_format($grandTotalSale, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p class="text-center text-gray-500">Nenhuma entrada de estoque encontrada para o período selecionado.</p>
            @endif
        </div>
    @endif
@endsection
