<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Requisições</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        .filters p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 11px;
        }
        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .section-header {
            background-color: #e6f3ff;
            padding: 10px;
            margin: 20px 0 10px 0;
            border-left: 4px solid #0066cc;
        }
        .section-header h2 {
            margin: 0;
            font-size: 16px;
            color: #0066cc;
        }
        .section-header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }
        .saida-header {
            background-color: #ffe6e6;
            border-left-color: #cc0000;
        }
        .saida-header h2 {
            color: #cc0000;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Requisições</h1>
        <p>Sistema de Gestão de Estoque</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p><strong>Tipo de Relatório:</strong> 
            @if($reportType == 'entrada')
                Entrada de Estoque
            @elseif($reportType == 'saida')
                Saída de Estoque
            @else
                Entrada/Saída
            @endif
        </p>
        <p><strong>Usuário:</strong> {{ $userName }}</p>
    </div>

    @if($reportType == 'entrada' || $reportType == 'entrada_saida')
        @if(isset($data['entrada']) && count($data['entrada']) > 0)
            <div class="section-header">
                <h2>Relatório de Entrada de Estoque</h2>
                <p>Produtos e quantidades que deram entrada no estoque através de requisições</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th>QTDE. REQUISITADA</th>
                        <th>PREÇO CUSTO TOTAL</th>
                        <th>PREÇO VENDA TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['entrada'] as $productName => $item)
                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>R$ {{ number_format($item['total_cost'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item['total_sale'], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td><strong>R$ {{ number_format($totals['entrada']['total_cost'], 2, ',', '.') }}</strong></td>
                        <td><strong>R$ {{ number_format($totals['entrada']['total_sale'], 2, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="section-header">
                <h2>Relatório de Entrada de Estoque</h2>
            </div>
            <div class="no-data">
                Nenhum dado de entrada encontrado para o período selecionado.
            </div>
        @endif
    @endif

    @if($reportType == 'saida' || $reportType == 'entrada_saida')
        @if($reportType == 'entrada_saida')
            <div class="page-break"></div>
        @endif

        @if(isset($data['saida']) && count($data['saida']) > 0)
            <div class="section-header saida-header">
                <h2>Relatório de Saída de Estoque</h2>
                <p>Produtos e quantidades que foram retirados do estoque através de requisições</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th>QTDE. RETIRADA DO ESTOQUE</th>
                        <th>PREÇO CUSTO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['saida'] as $productName => $item)
                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>R$ {{ number_format($item['total_cost'], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td><strong>R$ {{ number_format($totals['saida']['total_cost'], 2, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="section-header saida-header">
                <h2>Relatório de Saída de Estoque</h2>
            </div>
            <div class="no-data">
                Nenhum dado de saída encontrado para o período selecionado.
            </div>
        @endif
    @endif

    @if((!isset($data['entrada']) || count($data['entrada']) == 0) && (!isset($data['saida']) || count($data['saida']) == 0))
        <div class="no-data">
            <h3>Nenhum dado encontrado</h3>
            <p>Não foram encontrados registros para os filtros selecionados.</p>
        </div>
    @endif
</body>
</html>