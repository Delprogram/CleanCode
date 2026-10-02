<?php

declare(strict_types=1);

final class Customer
{
    public const TYPE_STANDARD = 'standard';
    public const TYPE_VIP = 'vip';

    public function __construct(
        public int $id,
        public string $email,
        public ?string $phone = null,
        public string $type = self::TYPE_STANDARD
    ) {
    }
}