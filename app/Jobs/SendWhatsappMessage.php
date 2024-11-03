<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $message;

    public function __construct($phoneNumber, $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    public function handle()
{
    try {
        $response = Http::post('https://express-wa-api-production.up.railway.app/send-message', [
            'phoneNumber' =>  $this->phoneNumber,
            'message' => $this->message,
        ]);

        Log::info('Response status: ' . $response->status());
        Log::info('Response body: ' . $response->body());

        if (!$response->successful()) {
            Log::error('Failed to send WhatsApp message: ' . $this->phoneNumber . ' | Status: ' . $response->status() . ' | Body: ' . $response->body());
        }
    } catch (\Exception $e) {
        Log::error('Exception occurred while sending WhatsApp message: ' . $e->getMessage());
    }
}

}
