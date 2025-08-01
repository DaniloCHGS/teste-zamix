<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Estoque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .entrada {
            color: green;
        }
        .saida {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Estoque</h1>
    </div>
    
    <div class="info">
        <p><strong>Tipo de Relatório:</strong> 
            @if($reportType == 'entradas')
                Entradas de Estoque
            @elseif($reportType == 'saidas')
                Saídas de Estoque
            @elseif($reportType == 'estoque_atual')
                Estoque Atual
            @endif
        </p>
        @if($reportType != 'estoque_atual')
            <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} @if(isset($endDate)) a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} @endif</p>
        @endif
        @if($reportType != 'estoque_atual')
            <p><strong>Usuário:</strong> {{ $userName ?? 'Todos' }}</p>
        @endif
        <p><strong>Data de Geração:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    @if(count($data) > 0)
        @if($reportType == 'entradas' || $reportType == 'saidas')
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Usuário</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td class="{{ $item->type }}">
                            {{ ucfirst($item->type) }}
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($reportType == 'estoque_atual')
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade em Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <p>Nenhum dado encontrado para os filtros selecionados.</p>
    @endif
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }} - Todos os direitos reservados</p>
    </div>
</body>
</html>