<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);

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
