@extends('layouts.main')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">

@section('content')

    <x-app-layout>
        <div class="container-slider">
           <button id="btn-prev"><i class="bi bi-chevron-left" id="next"></i></button>
               <div class="container-images">
                   <img src="{{ asset('img/carrosselImg/banner-artisan-j86z7z3rmj.webp') }}" alt="" class="slider on">
                   <img src="{{ asset('img/carrosselImg/banner-teclado-wooting-1-uzfiey3cz2.webp') }}" alt="" class="slider">
                   <img src="{{ asset('img/carrosselImg/banner-razer-1-1lbd24gcp9.webp') }}" alt="">
               </div>
           <button id="btn-next"><i class="bi bi-chevron-right" id="prev"></i></button>
        </div>

        <div class="produtos">
           <div class="marcas">
               <h1>Marcas que trabalhamos</h1>
               <div class="conteudoMarcas"> 
                   <ul>   
                       <li><img src="" alt=""></li> 
                       <li><img src="" alt=""></li>
                       <li><img src="" alt=""></li>
                       <li><img src="" alt=""></li>
                   </ul>
               </div>
           </div>
           <div class="recentes">
               <h1>Vistos Recentemente</h1>
           </div>
           <div class="maisVendidos">
               <h1>Mais vendidos</h1>
           </div>
           <div class="Lancamentos">
               <h1>Lançamentos</h1>
           </div>
        </div>
    </x-app-layout>

<script src="{{ asset('js/landing-page.js') }}"></script>    

@endsection