<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get(
    '/printful/products', function () {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.printful.com/products');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . env('PRINTFUL_API_KEY'),
                'X-PF-Language: en_GB',
            ]
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($result, true))
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
);

Route::get(
    '/printful/products/{id}', function ($id) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.printful.com/products/{$id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . env('PRINTFUL_API_KEY'),
                'X-PF-Language: en_GB',
            ]
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($result, true))
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
);
