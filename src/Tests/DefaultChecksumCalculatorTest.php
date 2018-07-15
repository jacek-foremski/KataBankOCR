<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\AccountNumber;
use KataBankOCR\DefaultChecksumCalculator;
use PHPUnit\Framework\TestCase;

class DefaultChecksumCalculatorTest extends TestCase
{
    /**
     * @var DefaultChecksumCalculator
     */
    private $checksumCalculator;

    public function setUp()
    {
        $this->checksumCalculator = new DefaultChecksumCalculator();
    }

    public function calculateProvider(): array
    {
        return
            [
                [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 5, 1]), 0],
                [new AccountNumber([4, 5, 7, 5, 0, 8, 0, 0, 0]), 0],
                [new AccountNumber([3, 4, 5, 8, 8, 2, 8, 6, 5]), 0],
                [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 5, 7]), 6],
                [new AccountNumber([6, 6, 4, 3, 7, 1, 4, 9, 5]), 2],
            ];
    }

    /**
     * @dataProvider calculateProvider
     */
    public function testCalculate(AccountNumber $accountNumber, int $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->checksumCalculator->calculate($accountNumber));
    }

    public function failProvider(): array
    {
        return
            [
                [new AccountNumber([0, null, 0, 0, 0, 0, 0, 5, 1])],
                [new AccountNumber([null, null, null, null, null, null, null, null, null])],
            ];
    }

    /**
     * @dataProvider failProvider
     * @expectedException \KataBankOCR\Exception\CalculateException
     */
    public function testCalculateFailIfHasIllegibleCharacters(AccountNumber $accountNumber): void
    {
        $this->checksumCalculator->calculate($accountNumber);
    }

    public function isValidProvider(): array
    {
        return
            [
                [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 5, 1]), true],
                [new AccountNumber([4, 5, 7, 5, 0, 8, 0, 0, 0]), true],
                [new AccountNumber([3, 4, 5, 8, 8, 2, 8, 6, 5]), true],
                [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 5, 7]), false],
                [new AccountNumber([6, 6, 4, 3, 7, 1, 4, 9, 5]), false],
            ];
    }

    /**
     * @dataProvider isValidProvider
     */
    public function testIsValid(AccountNumber $accountNumber, bool $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->checksumCalculator->isValid($accountNumber));
    }

    /**
     * @dataProvider failProvider
     * @expectedException \KataBankOCR\Exception\CalculateException
     */
    public function testIsValidFailIfHasIllegibleCharacters(AccountNumber $accountNumber): void
    {
        $this->checksumCalculator->isValid($accountNumber);
    }
}
