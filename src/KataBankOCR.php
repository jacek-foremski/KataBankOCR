<?php
declare(strict_types=1);

namespace KataBankOCR;

class KataBankOCR
{
    private const STATUS_ILLEGIBLE = 'ILL';
    private const STATUS_WRONG_CHECKSUM = 'ERR';

    /**
     * @var AccountNumberParser
     */
    private $accountNumberParser;

    /**
     * @var OutputFormatter
     */
    private $outputFormatter;

    /**
     * @var ChecksumCalculator
     */
    private $checksumCalculator;

    public function __construct(
        AccountNumberParser $accountNumberParser,
        OutputFormatter $outputFormatter,
        ?ChecksumCalculator $checksumCalculator = null)
    {
        $this->accountNumberParser = $accountNumberParser;
        $this->outputFormatter = $outputFormatter;
        $this->checksumCalculator = $checksumCalculator;
    }

    /**
     * Parses the file from the ingenious machine and returns account numbers with status.
     * @param $inputFileName
     * @return string
     * @throws Exception\CalculateException
     * @throws Exception\ParseException
     */
    public function parse($inputFileName): string
    {
        $parsedAccountNumbers = $this->accountNumberParser->parseMultiple(\file_get_contents($inputFileName));

        $formattedAccountNumbers = [];
        foreach ($parsedAccountNumbers as $accountNumber) {
            $formattedAccountNumbers[] = $this->formatAccountNumber($accountNumber);
        }

        return implode("\n", $formattedAccountNumbers) . "\n";
    }

    /**
     * @param $accountNumber
     * @return string
     * @throws Exception\CalculateException
     */
    private function formatAccountNumber(AccountNumber $accountNumber): string
    {
        $status = null;

        if ($accountNumber->hasIllegibleCharacters()) {
            $status = self::STATUS_ILLEGIBLE;
        } elseif ($this->checksumCalculator && !$this->checksumCalculator->isValid($accountNumber)) {
            $status = self::STATUS_WRONG_CHECKSUM;
        }

        return $this->outputFormatter->format($accountNumber, $status);
    }
}
