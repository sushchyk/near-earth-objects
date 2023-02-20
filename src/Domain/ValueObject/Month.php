<?php

namespace Neo\Domain\ValueObject;

use Neo\Domain\Exception\DomainException;

readonly class Month
{
    private const MONTHS = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    public static function fromNumber(int $number): static
    {
        return new Month($number);
    }

    private function __construct(private int $number)
    {
        if (!isset(static::MONTHS[$number])) {
            throw new DomainException(sprintf('%d is invalid month number', $number));
        }
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getFullName(): string
    {
        return self::MONTHS[$this->number];
    }
}
