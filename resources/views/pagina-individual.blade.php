@extends('layouts.main')

@section('title', 'Home')

@section('content')

    <div class="bg-white text-black max-w-[850px] mx-auto rounded-lg p-3">
        <div class="produto flex">
            <div class="imagem flex flex-col items-center">
                <div class="imagem-produto border border-black w-[400px] h-[400px] rounded">
                    <img src="" alt="">
                </div>
                <div class="carrossel-imagem flex">
                    <button><i class="bi bi-chevron-left rounded"></i></button>
                    <ul class="flex gap-2 pt-2">
                        <li class="border border-black w-[50px] h-[50px] rounded"><img src="" alt=""></li>
                        <li class="border border-black w-[50px] h-[50px] rounded"><img src="" alt=""></li>
                        <li class="border border-black w-[50px] h-[50px] rounded"><img src="" alt=""></li>
                    </ul>
                    <button><i class="bi bi-chevron-right rounded"></i></button>
                </div>
            </div>

            <div class="informacoes ml-3">

                <div class="titulo pb-10">
                    <h1 class="font-bold text-2xl">Titulo do Produto</h1>
                    <p id="estoque">Em estoque:</p>
                </div>

            <hr class="divisao border-black w-[350px]">

            <div id="preco">
                <p class="preco-pix text-[25px]"><strong>R$ 1000,00</strong> no pix</p>
                <p id="preco-cartao">até <strong>12x</strong> de <strong>R$ XX,XX</strong> sem juros</p>
            </div>
            

            <div class="comprar">
                <div class="quantidade">
                    <button class="font-bold"> - </button>
                    <input type="number" value="1" min="1" class="w-[50px] rounded-md text-center">
                    <button class="font-bold"> + </button>

                    <button class="bg-[#161A24] text-white p-2 w-[140px] rounded-md hover:bg-black transition-colors font-semibold">Comprar</button>
                </div>
            </div>
        </div>
        </div>
        <div class="descricao ">
                <h1 class="font-bold">Descrição</h1>
                <p class="text-[15px]">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit, repellendus rem asperiores architecto
                    neque laboriosam aut fugiat placeat non illo aliquam soluta pariatur officia, dolor nisi beatae ut
                    nobis. Enim.</p>

        </div>
    </div>