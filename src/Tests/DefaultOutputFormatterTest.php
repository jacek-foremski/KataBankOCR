<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\AccountNumber;
use KataBankOCR\DefaultOutputFormatter;
use PHPUnit\Framework\TestCase;

class DefaultOutputFormatterTest extends TestCase
{
    /**
     * @var DefaultOutputFormatter
     */
    private $outputFormatter;

    public function setUp()
    {
        $this->outputFormatter = new DefaultOutputFormatter();
    }

    public function formatProvider(): array
    {
        return
            [
                [new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9]), '123456789'],
                [new AccountNumber([1, null, 3, 4, 5, 6, 7, 8, 9]), '1?3456789'],
                [new AccountNumber([null, null, null, null, null, null, null, null, null]), '?????????'],
            ];
    }

    /**
     * @dataProvider formatProvider
     */
    public function testFormat(AccountNumber $accountNumber, string $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->outputFormatter->format($accountNumber));
    }

    public function formatWithStatusProvider(): array
    {
        return
            [
                [new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9]), null, '123456789'],
                [new AccountNumber([1, null, 3, 4, 5, 6, 7, 8, 9]), 'ILL', '1?3456789 ILL'],
                [new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9]), 'ERR', '123456789 ERR'],
            ];
    }

    /**
     * @dataProvider formatWithStatusProvider
     */
    public function testFormatWithStatus(AccountNumber $accountNumber, ?string $status, string $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->outputFormatter->format($accountNumber, $status));
    }
}
