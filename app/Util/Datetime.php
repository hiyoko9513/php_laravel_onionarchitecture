<?php

declare(strict_types=1);

namespace App\Util;

use DateTimeInterface;

final class Datetime
{
    private \Datetime $datetime;

    public function __construct(\Datetime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * Date and time format for use with Internet Protocol
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->datetime->format(DateTimeInterface::RFC3339);
    }
}
