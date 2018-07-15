<?php
declare(strict_types=1);

namespace KataBankOCR;

class DefaultOutputFormatter implements OutputFormatter
{
    /**
     * Formats the account number for outputting (printing).
     * @param AccountNumber $accountNumber
     * @param null|string $status Optional status code
     * @return string
     */
    public function format(AccountNumber $accountNumber, ?string $status = null): string
    {
        $formattedAccountNumber = \array_reduce($accountNumber->getDigits(), function ($carry, $item) {
            if ($item === null) {
                $item = '?';
            }

            return $carry . $item;
        }, '');

        if ($status !== null) {
            $formattedAccountNumber .= ' ' . $status;
        }

        return $formattedAccountNumber;
    }
}
