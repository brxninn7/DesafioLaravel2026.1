<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 8px; text-align: left; }
        th { background-color: #161A24; color: white; text-transform: uppercase; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .footer { margin-top: 20px; font-style: italic; font-size: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RELATÓRIO DE TRANSAÇÕES</h2>
        <p>Usuário Comprador: <strong>{{ auth()->user()->name }}</strong></p>
        <p>Data de Emissão: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Vendedor</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
            <tr>
                <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $compra->product->titulo ?? 'N/A' }}</td>
                <td>{{ $compra->product->categoria ?? 'Geral' }}</td>
                <td>{{ $compra->product->user->name ?? 'Sistema' }}</td>
                <td>R$ {{ number_format($compra->unit_price ?? 0, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        * Este documento lista as últimas transações realizadas pelo usuário logado.
    </div>
</body>
</html>