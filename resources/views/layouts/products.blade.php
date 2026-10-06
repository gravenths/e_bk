// resources/views/layouts/products.blade.php

use Illuminate\Support\Facades\Route;

Route::get('/products', function(){

$products = [
['name' => 'Laptop', 'price' => 1200],
['name' => 'Phone', 'price' => 800],
['name' => 'Headphones', 'price' => 150],
];

return view('products', compact('products'));
});

@extends('layouts.main')
@section('title', 'Products')

@section('content')
<h2>Our Products</h2>
<ul>
    @foreach($products as $product)
    <li>{{ $product['name'] }} - ${{ $product['price'] }}</li>
    @endforeach
</ul>
@endsection