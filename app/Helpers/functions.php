<?php

if (!function_exists('formatMoney')) {
    function formatMoney($value) {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}

if (!function_exists('onlyNumbers')) {
    function onlyNumbers($string) {
        return preg_replace('/\D/', '', $string);
    }
}