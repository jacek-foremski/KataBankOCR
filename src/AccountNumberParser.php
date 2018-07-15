<?php
declare(strict_types=1);

namespace KataBankOCR;

use KataBankOCR\Exception\ParseException;

class AccountNumberParser
{
    private const DIGIT_LENGTH = 3;
    private const DIGIT_LINES = 4;
    private const LINE_LENGTH = AccountNumber::NUMBER_OF_DIGITS * self::DIGIT_LENGTH;
    private const CHARACTERS_IN_ACCOUNT_NUMBER = (self::LINE_LENGTH + 1) * self::DIGIT_LINES;

    /**
     * @var DigitParser
     */
    private $digitParser;

    /**
     * @var string[]
     */
    private $rawDigits;

    /**
     * @var int[]|null[]
     */
    private $parsedDigits;

    public function __construct(DigitParser $digitParser)
    {
        $this->digitParser = $digitParser;
    }

    /**
     * @param string $accountNumbers
     * @return AccountNumber[]
     * @throws ParseException
     */
    public function parseMultiple(string $accountNumbers): array
    {
        $splitAccountNumbers = \str_split($accountNumbers, self::CHARACTERS_IN_ACCOUNT_NUMBER);

        $parsedAccountNumbers = [];
        foreach ($splitAccountNumbers as $accountNumber) {
            $parsedAccountNumbers[] = $this->parse(\rtrim($accountNumber, "\n"));
        }

        return $parsedAccountNumbers;
    }

    /**
     * @param string $accountNumber
     * @return AccountNumber
     * @throws ParseException
     */
    public function parse(string $accountNumber): AccountNumber
    {
        $this->splitIntoDigits($accountNumber);
        $this->parseDigits();

        return new AccountNumber($this->parsedDigits);
    }

    /**
     * @param string $accountNumber
     * @throws ParseException
     */
    private function splitIntoDigits(string $accountNumber): void
    {
        $this->rawDigits = \array_fill(0, AccountNumber::NUMBER_OF_DIGITS, '');

        $lines = \explode("\n", $accountNumber);
        if (!$this->areLinesValid($lines)) {
            throw new ParseException($accountNumber);
        }

        foreach ($lines as $line) {
            $this->processLine($line);
        }
    }

    private function areLinesValid(array $lines): bool
    {
        if (\count($lines) !== self::DIGIT_LINES) {
            return false;
        }

        foreach ($lines as $line) {
            if (\strlen($line) !== self::LINE_LENGTH) {
                return false;
            }
        }

        return true;
    }

    private function processLine(string $line): void
    {
        $chunks = \str_split($line, self::DIGIT_LENGTH);

        for ($i = 0; $i < AccountNumber::NUMBER_OF_DIGITS; $i++) {
            $this->rawDigits[$i] .= $chunks[$i];
        }
    }

    private function parseDigits(): void
    {
        $this->parsedDigits = [];
        foreach ($this->rawDigits as $digit) {
            $this->parsedDigits[] = $this->digitParser->parse($digit);
        }
    }
}
