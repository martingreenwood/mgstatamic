<?php

use App\Mail\ContactEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/sanctum/csrf-cookie', function () {
    csrf_token();

    return response()->noContent();
});

Route::post('/api/contact', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:255'],
        'company' => ['nullable', 'string', 'max:160'],
        'projectType' => ['required', 'string', 'max:120'],
        'message' => ['required', 'string', 'max:5000'],
        'website' => ['nullable', 'string', 'max:255'],
    ]);

    if (filled($data['website'] ?? null)) {
        return response()->noContent();
    }

    Mail::to(config('mail.contact_recipient', 'hello@martingreenwood.com'))
        ->send(new ContactEnquiry($data));

    return response()->noContent();
});

Route::get(
    '/printful/products', function () {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.printful.com/products');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer '.env('PRINTFUL_API_KEY'),
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
                'Authorization: Bearer '.env('PRINTFUL_API_KEY'),
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
