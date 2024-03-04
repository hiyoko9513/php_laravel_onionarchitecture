<?php

declare(strict_types=1);

namespace App\Util;

use App\Exceptions\Util\ExchangeDatetimeException;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;

const DATE_FORMAT = 'Y-m-d';

final class Datetime
{
    private DateTimeImmutable $datetime;

    public function __construct(string $dateString = 'now')
    {
        try {
            $datetime = new DateTimeImmutable($dateString);
        } catch (Exception) {
            throw new ExchangeDatetimeException();
        }
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
