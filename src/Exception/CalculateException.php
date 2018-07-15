<?php
declare(strict_types=1);

namespace KataBankOCR\Exception;

use KataBankOCR\AccountNumber;

class CalculateException extends \Exception implements KataBankOCRException
{
    /**
     * @var AccountNumber
     */
    public $accountNumber;

    public function __construct(AccountNumber $accountNumber)
    {
        $this->accountNumber = $accountNumber;

        parent::__construct(sprintf('Cannot calculate checksum for AccountNumbers with illegal characters'));
    }
}
