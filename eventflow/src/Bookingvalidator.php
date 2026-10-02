<?php

declare(strict_types=1);

final class BookingValidator
{
    public function validate(Booking $booking): void
    {
        $this->assertHasItems($booking);
        $this->assertCustomerEmailIsValid($booking->customer);
        $this->assertItemQuantitiesArePositive($booking);
    }

    private function assertHasItems(Booking $booking): void
    {
        if (count($booking->items) === 0) {
            throw new RuntimeException('Empty booking');
        }
    }

    private function assertCustomerEmailIsValid(Customer $customer): void
    {
        if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email');
        }
    }

    private function assertItemQuantitiesArePositive(Booking $booking): void
    {
        foreach ($booking->items as $item) {
            $this->assertQuantityIsPositive($item);
        }
    }

    private function assertQuantityIsPositive(BookingItem $item): void
    {
        if ($item->quantity <= 0) {
            throw new RuntimeException('Invalid quantity');
        }
    }
}