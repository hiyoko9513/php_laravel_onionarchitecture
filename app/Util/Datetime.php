<?php

declare(strict_types=1);

namespace App\Util;

use DateTimeImmutable;
use DateTimeInterface;

const DATE_FORMAT = 'Y-m-d';

final class Datetime
{
    private DateTimeImmutable $datetime;

    public function __construct(DateTimeImmutable $datetime = new DateTimeImmutable('now'))
    {
        $this->datetime = $datetime;
    }

    /**
     * Date format for use with Internet Protocol
     */
    public function toDateString(): string
    {
        return $this->datetime->format(DATE_FORMAT);
    }

    /**
     * Datetime format for use with Internet Protocol
     */
    public function toRFC3339String(): string
    {
        return $this->datetime->format(DateTimeInterface::RFC3339);
    }
}
