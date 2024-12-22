<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/printful/products', function () {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PRINTFUL_API_KEY'),
        'X-PF-Language' => 'en_GB',
    ])->get('https://api.printful.com/products');

    return response()->json($response->json(), $response->status());
});

Route::get('/printful/products/{id}', function ($id) {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PRINTFUL_API_KEY'),
        'X-PF-Language' => 'en_GB',
    ])->get("https://api.printful.com/products/{$id}");

    return response()->json($response->json(), $response->status());
});
