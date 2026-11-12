<?php

namespace App\Services;

use App\Models\ContactRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function isConfigured(): bool
    {
        return filled(config('services.whatsapp.token'))
            && filled(config('services.whatsapp.phone_number_id'));
    }

    public function sendContactNotifications(ContactRequest $contactRequest): void
    {
        if (! $this->isConfigured()) {
            return;
        }

        $this->sendTemplate(
            $this->normalizeNumber($contactRequest->phone),
            config('services.whatsapp.greeting_template'),
            [$contactRequest->name],
        );

        $owner = config('services.whatsapp.owner_number');
        if (filled($owner)) {
            $this->sendTemplate(
                $this->normalizeNumber($owner),
                config('services.whatsapp.owner_template'),
                [$contactRequest->name, $contactRequest->phone, $contactRequest->message],
            );
        }
    }

    private function sendTemplate(string $to, string $template, array $parameters): void
    {
        $components = [[
            'type' => 'body',
            'parameters' => array_map(
                fn (string $value) => ['type' => 'text', 'text' => mb_substr($value, 0, 1024)],
                $parameters,
            ),
        ]];

        try {
            $response = Http::withToken(config('services.whatsapp.token'))
                ->acceptJson()
                ->timeout(10)
                ->post($this->endpoint(), [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'template',
                    'template' => [
                        'name' => $template,
                        'language' => ['code' => config('services.whatsapp.language')],
                        'components' => $components,
                    ],
                ]);

            if ($response->failed()) {
                Log::warning('WhatsApp message failed', ['to' => $to, 'status' => $response->status(), 'body' => $response->json()]);
            }
        } catch (\Throwable $e) {
            Log::warning('WhatsApp request error', ['to' => $to, 'error' => $e->getMessage()]);
        }
    }

    private function endpoint(): string
    {
        return 'https://graph.facebook.com/v21.0/'.config('services.whatsapp.phone_number_id').'/messages';
    }

    private function normalizeNumber(string $number): string
    {
        return preg_replace('/\D+/', '', $number) ?? '';
    }
}
