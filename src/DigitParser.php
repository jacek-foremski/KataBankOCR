<?php
declare(strict_types=1);

namespace KataBankOCR;

interface DigitParser
{
    /**
     * Parses the raw digit to integer. Returns null if it cannot be parsed.
     * @param string $digit
     * @return int|null
     */
    public function parse(string $digit): ?int;
}
