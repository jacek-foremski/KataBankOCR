<?php
declare(strict_types=1);

namespace KataBankOCR;

use KataBankOCR\Exception\CalculateException;

class DefaultChecksumCalculator implements ChecksumCalculator
{
    private const DIVISOR = 11;

    /**
     * Checks if the checksum of an account number is valid.
     * @param AccountNumber $accountNumber
     * @return bool
     * @throws CalculateException if checksum cannot be calculated
     */
    public function isValid(AccountNumber $accountNumber): bool
    {
        return $this->calculate($accountNumber) === 0;
    }

    /**
     * Calculates the checksum of an account number.
     * @param AccountNumber $accountNumber
     * @return int checksum
     * @throws CalculateException if checksum cannot be calculated
     */
    public function calculate(AccountNumber $accountNumber): int
    {
        if ($accountNumber->hasIllegibleCharacters()) {
            throw new CalculateException($accountNumber);
        }

        $digits = $accountNumber->getDigits();

        $sum = 0;
        $multiplier = AccountNumber::NUMBER_OF_DIGITS;
        for ($i = 0; $i < AccountNumber::NUMBER_OF_DIGITS; $i++, $multiplier--) {
            $sum += $digits[$i] * $multiplier;
        }

        return $sum % self::DIVISOR;
    }

}
