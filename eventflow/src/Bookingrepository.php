<?php

declare(strict_types=1);

final class BookingRepository
{
    public function save(Booking $booking, float $total): void
    {
        echo "SQL INSERT booking={$booking->id} total={$total} status={$booking->status}" . PHP_EOL;
    }
}