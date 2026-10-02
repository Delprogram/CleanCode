<?php

declare(strict_types=1);

final class BookingService
{
    public function __construct(
        private BookingValidator $validator = new BookingValidator(),
        private BookingPriceCalculator $priceCalculator = new BookingPriceCalculator(),
        private BookingRepository $repository = new BookingRepository()
    ) {
    }

    public function confirm(Booking $booking, string $paymentMethod = 'stripe'): float
    {
        $this->validator->validate($booking);

        $total = $this->priceCalculator->calculateTotal($booking);

        $this->charge($total, $paymentMethod);

        $this->markAsConfirmed($booking);
        $this->repository->save($booking, $total);
        $this->sendConfirmationEmail($booking);

        return $total;
    }

    private function charge(float $total, string $paymentMethod): void
    {
        if ($paymentMethod === 'stripe') {
            $stripe = new StripeClient();
            $transactionId = $stripe->charge($total);
            echo "PAYMENT {$transactionId}" . PHP_EOL;

            return;
        }

        if ($paymentMethod === 'payfast') {
            throw new RuntimeException('PayFast not implemented');
        }

        throw new RuntimeException('Unknown payment method');
    }

    private function markAsConfirmed(Booking $booking): void
    {
        $booking->status = Booking::STATUS_CONFIRMED;
    }

    private function sendConfirmationEmail(Booking $booking): void
    {
        $emailService = new EmailService();
        $emailService->sendConfirmation($booking->customer->email, $booking->id);
    }
}