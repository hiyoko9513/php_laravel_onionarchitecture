<?php

declare(strict_types=1);

namespace App\Util;

final class Date
{
    private int $timestamp;

    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Date and time format for use with Internet Protocol
     *
     * @return string
     */
    public function toString(): string
    {
        return date('Y-m-d', $this->timestamp);
    }
}
