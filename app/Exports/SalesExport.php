<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $vendas;

    public function __construct($vendas)
    {
        $this->vendas = $vendas;
    }

    public function collection()
    {
        return $this->vendas;
    }

    public function headings(): array
    {
        return [
            'Data',
            'Produto',
            'Categoria',
            'Comprador',
            'Vendedor',
            'Valor'
        ];
    }

    public function map($venda): array
    {
        return [
            $venda->created_at->format('d/m/Y H:i'),
            $venda->product->titulo ?? 'N/A',
            $venda->product->categoria ?? 'Geral',
            $venda->user->name ?? 'N/A',
            $venda->product->user->name ?? 'Sistema',
            'R$ ' . number_format($venda->unit_price, 2, ',', '.')
        ];
    }
}