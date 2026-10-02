<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$customer = new Customer(
    id: 42,
    email: 'lea@example.com',
    phone: '0612345678',
    type: Customer::TYPE_VIP
);

$dayTicket = new Ticket(
    code: 'DAY-1',
    label: 'Pass Jour 1',
    price: 79.90
);

$booking = new Booking(
    id: 1001,
    customer: $customer,
    passType: Booking::PASS_DAY
);

$booking->addItem(new BookingItem($dayTicket, 2));

$service = new BookingService();
$total = $service->confirm($booking, 'stripe');

echo 'TOTAL FINAL: ' . number_format($total, 2, '.', '') . PHP_EOL;