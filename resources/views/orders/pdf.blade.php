<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 10px; text-align: left; }
        th { background-color: #161A24; color: white; text-transform: uppercase; font-size: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .total { font-weight: bold; color: #000; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Relatório de Compras</h2>
        <p>Cliente: {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Data</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
            <tr>
                <td>{{ $compra->product->nome ?? 'Produto Removido' }}</td>
                <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                <td class="total">R$ {{ number_format($compra->valor_pago ?? 0, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>