<?php

namespace Tests\Feature;

use Tests\TestCase;

class CorsTest extends TestCase
{
    public function test_api_requests_from_the_website_receive_cors_headers(): void
    {
        $response = $this
            ->withHeader('Origin', 'https://martingreenwood.com')
            ->get('/api/collections/insights/entries?limit=3');

        $response->assertHeader('Access-Control-Allow-Origin', 'https://martingreenwood.com');
    }

    public function test_api_requests_from_unknown_origins_are_not_allowed(): void
    {
        $response = $this
            ->withHeader('Origin', 'https://example.com')
            ->get('/api/collections/insights/entries?limit=3');

        $response->assertHeaderMissing('Access-Control-Allow-Origin');
    }
}
