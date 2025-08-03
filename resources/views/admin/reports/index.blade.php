@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Relatórios de Requisições</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de Filtro -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Data Inicial:</label>
                <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $startDate ?? '' }}" required>
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Data Final (opcional):</label>
                <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $endDate ?? '' }}">
            </div>
            <div>
                <label for="report_type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Relatório:</label>
                <select name="report_type" id="report_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="" disabled {{ !isset($reportType) ? 'selected' : '' }}>Selecione um tipo</option>
                    <option value="entrada" {{ isset($reportType) && $reportType == 'entrada' ? 'selected' : '' }}>Entrada de Estoque</option>
                    <option value="saida" {{ isset($reportType) && $reportType == 'saida' ? 'selected' : '' }}>Saída de Estoque</option>
                    <option value="entrada_saida" {{ isset($reportType) && $reportType == 'entrada_saida' ? 'selected' : '' }}>Entrada/Saída</option>
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Usuário:</label>
                <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="todos" {{ isset($userId) && $userId == 'todos' ? 'selected' : '' }}>Todos os usuários</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ isset($userId) && $userId == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Buscar Dados
                </button>
                @if(isset($data) && (isset($data['entrada']) || isset($data['saida'])))
                <button type="submit" name="export_pdf" value="1" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Exportar PDF
                </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Resultados dos Relatórios -->
    @if(isset($data))
        <!-- Relatório de Entrada -->
        @if(isset($data['entrada']) && count($data['entrada']) > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="bg-blue-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-800">Relatório de Entrada de Estoque</h2>
                    <p class="text-sm text-blue-600">Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                </div>
                
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                PRODUTO
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                QTDE. REQUISITADA
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                PREÇO CUSTO TOTAL
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                PREÇO VENDA TOTAL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['entrada'] as $productName => $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $productName }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $item['quantity'] }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                R$ {{ number_format($item['total_cost'], 2, ',', '.') }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                R$ {{ number_format($item['total_sale'], 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                        <!-- Linha de Total -->
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-5 py-4 text-sm font-bold">Total</td>
                            <td class="px-5 py-4 text-sm"></td>
                            <td class="px-5 py-4 text-sm font-bold">R$ {{ number_format($totals['entrada']['total_cost'], 2, ',', '.') }}</td>
                            <td class="px-5 py-4 text-sm font-bold">R$ {{ number_format($totals['entrada']['total_sale'], 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Relatório de Saída -->
        @if(isset($data['saida']) && count($data['saida']) > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="bg-red-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-red-800">Relatório de Saída de Estoque</h2>
                    <p class="text-sm text-red-600">Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                </div>
                
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                PRODUTO
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                QTDE. RETIRADA DO ESTOQUE
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                PREÇO CUSTO TOTAL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['saida'] as $productName => $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $productName }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $item['quantity'] }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                R$ {{ number_format($item['total_cost'], 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                        <!-- Linha de Total -->
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-5 py-4 text-sm font-bold">Total</td>
                            <td class="px-5 py-4 text-sm"></td>
                            <td class="px-5 py-4 text-sm font-bold">R$ {{ number_format($totals['saida']['total_cost'], 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Mensagem quando não há dados -->
        @if((!isset($data['entrada']) || count($data['entrada']) == 0) && (!isset($data['saida']) || count($data['saida']) == 0))
            <div class="bg-white shadow-md rounded-lg p-8 text-center">
                <div class="text-gray-500 mb-4">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium">Nenhum dado encontrado</h3>
                </div>
                <p class="text-gray-600">Não foram encontrados registros para os filtros selecionados.</p>
            </div>
        @endif
    @endif
</div>
@endsection