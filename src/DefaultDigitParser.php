<?php
declare(strict_types=1);

namespace KataBankOCR;

class DefaultDigitParser implements DigitParser
{
    /**
     * @var array
     */
    protected $parsingTable = [
        ' _ ' .
        '| |' .
        '|_|' .
        '   ' => 0,
        '   ' .
        '  |' .
        '  |' .
        '   ' => 1,
        ' _ ' .
        ' _|' .
        '|_ ' .
        '   ' => 2,
        ' _ ' .
        ' _|' .
        ' _|' .
        '   ' => 3,
        '   ' .
        '|_|' .
        '  |' .
        '   ' => 4,
        ' _ ' .
        '|_ ' .
        ' _|' .
        '   ' => 5,
        ' _ ' .
        '|_ ' .
        '|_|' .
        '   ' => 6,
        ' _ ' .
        '  |' .
        '  |' .
        '   ' => 7,
        ' _ ' .
        '|_|' .
        '|_|' .
        '   ' => 8,
        ' _ ' .
        '|_|' .
        ' _|' .
        '   ' => 9,
    ];

    /**
     * Parses the raw digit to integer. Returns null if it cannot be parsed.
     * @param string $digit
     * @return int|null
     */
    public function parse(string $digit): ?int
    {
        if (!isset($this->parsingTable[$digit])) {
            return null;
        }

        return $this->parsingTable[$digit];
    }
}
