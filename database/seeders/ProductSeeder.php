<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'titulo' => 'Teclado Mecânico RGB',
            'descricao' => 'Teclado gamer com switches blue',
            'preco' => 299.90,
            'estoque' => 15,
            'marca' => 'Redragon',
            'tipo' => 'Periférico',
            'categoria' => 'Teclado',
        ]);

        Product::create([
            'titulo' => 'Mouse Gamer 16000 DPI',
            'descricao' => 'Mouse profissional para FPS',
            'preco' => 189.90,
            'estoque' => 20,
            'marca' => 'Logitech',
            'tipo' => 'Periférico',
            'categoria' => 'Mouse',
        ]);

        Product::create([
            'titulo' => 'Placa de Vídeo RTX 4060',
            'descricao' => '8GB GDDR6',
            'preco' => 2499.90,
            'estoque' => 5,
            'marca' => 'Nvidia',
            'tipo' => 'Hardware',
            'categoria' => 'GPU',
        ]);
    }
}
