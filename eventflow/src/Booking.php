<?php

declare(strict_types=1);

final class Booking
{
    public const PASS_DAY = 'day';
    public const PASS_THREE_DAYS = '3days';

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';

    /** @var BookingItem[] */
    public array $items = [];
    public string $status = self::STATUS_PENDING;

    public function __construct(
        public int $id,
        public Customer $customer,
        public string $passType = self::PASS_DAY
    ) {
    }

    public function addItem(BookingItem $item): void
    {
        $this->items[] = $item;
    }
}