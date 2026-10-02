<?php

declare(strict_types=1);

final class BookingPriceCalculator
{
    private const VIP_DISCOUNT_RATE = 0.10;
    private const THREE_DAYS_PASS_DISCOUNT = 10.0;

    public function calculateTotal(Booking $booking): float
    {
        $total = $this->sumItems($booking);
        $total = $this->applyVipDiscount($booking->customer, $total);

        return $this->applyThreeDaysPassDiscount($booking, $total);
    }

    private function sumItems(Booking $booking): float
    {
        $total = 0.0;

        foreach ($booking->items as $item) {
            $total += $item->ticket->price * $item->quantity;
        }

        return $total;
    }

    private function applyVipDiscount(Customer $customer, float $total): float
    {
        if ($customer->type !== Customer::TYPE_VIP) {
            return $total;
        }

        return $total * (1 - self::VIP_DISCOUNT_RATE);
    }

    private function applyThreeDaysPassDiscount(Booking $booking, float $total): float
    {
        if ($booking->passType !== Booking::PASS_THREE_DAYS) {
            return $total;
        }

        return $total - self::THREE_DAYS_PASS_DISCOUNT;
    }
}