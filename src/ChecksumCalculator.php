<?php
declare(strict_types=1);

namespace KataBankOCR;

use KataBankOCR\Exception\CalculateException;

interface ChecksumCalculator
{
    /**
     * Checks if the checksum of an account number is valid.
     * @param AccountNumber $accountNumber
     * @return bool
     * @throws CalculateException if checksum cannot be calculated
     */
    public function isValid(AccountNumber $accountNumber): bool;

    /**
     * Calculates the checksum of an account number.
     * @param AccountNumber $accountNumber
     * @return int checksum
     * @throws CalculateException if checksum cannot be calculated
     */
    public function calculate(AccountNumber $accountNumber): int;
}