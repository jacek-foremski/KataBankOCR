<?php
declare(strict_types=1);

namespace KataBankOCR;

interface OutputFormatter
{
    /**
     * Formats the account number for outputting (printing).
     * @param AccountNumber $accountNumber
     * @param null|string $status Optional status code
     * @return string
     */
    public function format(AccountNumber $accountNumber, ?string $status = null): string;
}
