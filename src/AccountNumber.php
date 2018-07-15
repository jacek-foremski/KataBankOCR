<?php
declare(strict_types=1);

namespace KataBankOCR;

use KataBankOCR\Exception\InvalidAccountNumberException;

class AccountNumber
{
    public const NUMBER_OF_DIGITS = 9;

    /**
     * @var array
     */
    protected $digits;

    /**
     * @param array $digits array of digits that make up the account number.
     * Null is accepted in place of any digit and it denotes that the character is illegible.
     */
    public function __construct(array $digits)
    {
        if (!$this->isInputValid($digits)) {
            throw new InvalidAccountNumberException($digits);
        }

        $this->digits = $digits;
    }

    protected function isInputValid(array $digits): bool
    {
        if (\count($digits) !== self::NUMBER_OF_DIGITS) {
            return false;
        }

        foreach ($digits as $value) {
            if (!\is_int($value) && $value !== null) {
                return false;
            }

            if ($value < 0 || $value > 9) {
                return false;
            }
        }

        for ($i = 0; $i < self::NUMBER_OF_DIGITS; $i++) {
            if (!\array_key_exists($i, $digits)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getDigits(): array
    {
        return $this->digits;
    }

    /**
     * @return bool returns true if the account number has any illegible characters (denoted as nulls)
     */
    public function hasIllegibleCharacters(): bool
    {
        if (\in_array(null, $this->digits, true)) {
            return true;
        }

        return false;
    }
}
