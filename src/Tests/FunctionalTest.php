<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\AccountNumberParser;
use KataBankOCR\DefaultChecksumCalculator;
use KataBankOCR\DefaultDigitParser;
use KataBankOCR\DefaultOutputFormatter;
use KataBankOCR\KataBankOCR;
use PHPUnit\Framework\TestCase;

class FunctionalTest extends TestCase
{

    public function testUseCase1(): void
    {
        $digitParser = new DefaultDigitParser();
        $accountNumberParser = new AccountNumberParser($digitParser);
        $outputFormatter = new DefaultOutputFormatter();
        $kataBankOCR = new KataBankOCR($accountNumberParser, $outputFormatter);

        $result = $kataBankOCR->parse(__DIR__ . '/fixtures/use_case_1_in.txt');

        self::assertStringEqualsFile(__DIR__ . '/fixtures/use_case_1_out.txt', $result);
    }

    public function testUseCase3(): void
    {
        $digitParser = new DefaultDigitParser();
        $accountNumberParser = new AccountNumberParser($digitParser);
        $outputFormatter = new DefaultOutputFormatter();
        $checksumCalculator = new DefaultChecksumCalculator();
        $kataBankOCR = new KataBankOCR($accountNumberParser, $outputFormatter, $checksumCalculator);

        $result = $kataBankOCR->parse(__DIR__ . '/fixtures/use_case_3_in.txt');

        self::assertStringEqualsFile(__DIR__ . '/fixtures/use_case_3_out.txt', $result);
    }
}
