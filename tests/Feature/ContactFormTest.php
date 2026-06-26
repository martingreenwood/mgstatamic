<?php

namespace Tests\Feature;

use App\Mail\ContactEnquiry;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_csrf_cookie_endpoint_exists(): void
    {
        $this->get('/sanctum/csrf-cookie')
            ->assertNoContent()
            ->assertCookie('XSRF-TOKEN');
    }

    public function test_valid_contact_submission_sends_mail_and_returns_no_content(): void
    {
        Mail::fake();

        config(['mail.contact_recipient' => 'hello@martingreenwood.com']);

        $payload = $this->validPayload();

        $this->postJson('/api/contact', $payload)
            ->assertNoContent();

        Mail::assertSent(ContactEnquiry::class, function (ContactEnquiry $mail) use ($payload) {
            return $mail->hasTo('hello@martingreenwood.com')
                && $mail->enquiry['email'] === $payload['email']
                && $mail->enquiry['projectType'] === $payload['projectType'];
        });
    }

    public function test_honeypot_submission_returns_no_content_and_sends_no_mail(): void
    {
        Mail::fake();

        $this->postJson('/api/contact', [
            ...$this->validPayload(),
            'website' => 'https://spam.example',
        ])->assertNoContent();

        Mail::assertNothingSent();
    }

    public function test_invalid_payload_returns_validation_json(): void
    {
        Mail::fake();

        $this->postJson('/api/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'projectType' => '',
            'message' => '',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'projectType', 'message']);

        Mail::assertNothingSent();
    }

    private function validPayload(): array
    {
        return [
            'name' => 'Martin Greenwood',
            'email' => 'martin@example.com',
            'company' => 'MG Studio',
            'projectType' => 'Website build',
            'message' => 'I would like to talk about a new project.',
            'website' => '',
        ];
    }
}
