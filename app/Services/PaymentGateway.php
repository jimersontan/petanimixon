<?php

namespace App\Services;

use App\Models\Order;

interface PaymentGateway
{
    /**
     * Create a payment intent/session for the given order.
     *
     * @return array{success: bool, redirect_url: string|null, reference: string, message: string}
     */
    public function createPayment(Order $order): array;

    /**
     * Verify a payment by its reference.
     *
     * @return array{verified: bool, status: string, message: string}
     */
    public function verifyPayment(string $reference): array;
}
