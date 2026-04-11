<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;

class MockPaymentGateway implements PaymentGateway
{
    /**
     * Simulate creating a payment — instantly returns success with a mock reference.
     */
    public function createPayment(Order $order): array
    {
        $reference = 'PAY-' . strtoupper(Str::random(12));

        // In a real gateway, this would return a checkout URL to redirect to
        return [
            'success' => true,
            'redirect_url' => route('checkout.payment.callback', [
                'reference' => $reference,
                'order_id' => $order->order_id,
                'status' => 'success',
            ]),
            'reference' => $reference,
            'message' => 'Mock payment created successfully.',
        ];
    }

    /**
     * Simulate verifying a payment — always returns verified.
     */
    public function verifyPayment(string $reference): array
    {
        return [
            'verified' => true,
            'status' => 'paid',
            'message' => 'Mock payment verified.',
        ];
    }
}
