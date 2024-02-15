<?php

declare(strict_types=1);

namespace App\Util;

use DateTimeInterface;

const DATE_FORMAT = 'Y-m-d';

final class Datetime
{

    private \Datetime $datetime;

    public function __construct(\Datetime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * Datetime format for use with Internet Protocol
     *
     * @return string
     */
    public function toRFC3339String(): string
    {
        return $this->datetime->format(DateTimeInterface::RFC3339);
    }

    /**
     * Date format for use with Internet Protocol
     *
     * @return string
     */
    public function toDateString(): string
    {
        return $this->datetime->format(DATE_FORMAT);
    }
}
