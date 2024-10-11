<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/categories', function () {
    return view('categories');
});

Route::get('/products', function () {
    return view('products');
});
//Route::get('/home', function () {})
