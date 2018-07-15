<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\AccountNumber;
use KataBankOCR\AccountNumberParser;
use KataBankOCR\DefaultDigitParser;
use PHPUnit\Framework\TestCase;

class AccountNumberParserTest extends TestCase
{
    /**
     * @var AccountNumberParser
     */
    private $accountNumberParser;

    public function setUp()
    {
        // Using a real thing instead of a Mock because of the simplicity of this class.
        $digitParser = new DefaultDigitParser();
        $this->accountNumberParser = new AccountNumberParser($digitParser);
    }

    public function parseProvider(): array
    {
        return
            [
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '| || || || || || || || || |' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ', new AccountNumber([0, 0, 0, 0, 0, 0, 0, 0, 0])],
                [
                    '                           ' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ', new AccountNumber([1, 1, 1, 1, 1, 1, 1, 1, 1])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '                           ', new AccountNumber([2, 2, 2, 2, 2, 2, 2, 2, 2])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ', new AccountNumber([3, 3, 3, 3, 3, 3, 3, 3, 3])],
                [
                    '                           ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ', new AccountNumber([4, 4, 4, 4, 4, 4, 4, 4, 4])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ', new AccountNumber([5, 5, 5, 5, 5, 5, 5, 5, 5])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ', new AccountNumber([6, 6, 6, 6, 6, 6, 6, 6, 6])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ', new AccountNumber([7, 7, 7, 7, 7, 7, 7, 7, 7])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ', new AccountNumber([8, 8, 8, 8, 8, 8, 8, 8, 8])],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ', new AccountNumber([9, 9, 9, 9, 9, 9, 9, 9, 9])],
                [
                    '    _  _     _  _  _  _  _ ' . "\n" .
                    '  | _| _||_||_ |_   ||_||_|' . "\n" .
                    '  ||_  _|  | _||_|  ||_| _|' . "\n" .
                    '                           ', new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9])],
                [
                    '    _  _     _  _  _  _  _ ' . "\n" .
                    '  | _| _||_||_ |    ||_||_|' . "\n" .
                    '  ||_  _|  | _||_|  ||_| _|' . "\n" .
                    '                           ', new AccountNumber([1, 2, 3, 4, 5, null, 7, 8, 9])],
            ];
    }

    /**
     * @dataProvider parseProvider
     */
    public function testParse(string $accountNumber, AccountNumber $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->accountNumberParser->parse($accountNumber));
    }

    public function parseFailProvider(): array
    {
        return
            [
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '| || || || || || || || || |' . "\n"],
                [
                    '                           ' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' .
                    '                           ' . "\n"],
                [
                    ' _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _|' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '                        '],
                [
                    ' _  _  _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _| _|' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '                              '],
            ];
    }

    /**
     * @expectedException \KataBankOCR\Exception\ParseException
     * @dataProvider parseFailProvider
     */
    public function testParseFailIfUnparsable(string $accountNumber): void
    {
        $this->accountNumberParser->parse($accountNumber);
    }

    public function parseMultipleProvider(): array
    {
        return
            [
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '| || || || || || || || || |' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ',
                    [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 0, 0])]
                ],
                [
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '| || || || || || || || || |' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ' . "\n" .
                    '                           ' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ' . "\n" .
                    '                           ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_ |_ |_ |_ |_ |_ |_ |_ |_ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '  |  |  |  |  |  |  |  |  |' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    '                           ' . "\n" .
                    ' _  _  _  _  _  _  _  _  _ ' . "\n" .
                    '|_||_||_||_||_||_||_||_||_|' . "\n" .
                    ' _| _| _| _| _| _| _| _| _|' . "\n" .
                    '                           ' . "\n" .
                    '    _  _     _  _  _  _  _ ' . "\n" .
                    '  | _| _||_||_ |_   ||_||_|' . "\n" .
                    '  ||_  _|  | _||_|  ||_| _|' . "\n" .
                    '                           ' . "\n",
                    [
                        new AccountNumber([0, 0, 0, 0, 0, 0, 0, 0, 0]),
                        new AccountNumber([1, 1, 1, 1, 1, 1, 1, 1, 1]),
                        new AccountNumber([2, 2, 2, 2, 2, 2, 2, 2, 2]),
                        new AccountNumber([3, 3, 3, 3, 3, 3, 3, 3, 3]),
                        new AccountNumber([4, 4, 4, 4, 4, 4, 4, 4, 4]),
                        new AccountNumber([5, 5, 5, 5, 5, 5, 5, 5, 5]),
                        new AccountNumber([6, 6, 6, 6, 6, 6, 6, 6, 6]),
                        new AccountNumber([7, 7, 7, 7, 7, 7, 7, 7, 7]),
                        new AccountNumber([8, 8, 8, 8, 8, 8, 8, 8, 8]),
                        new AccountNumber([9, 9, 9, 9, 9, 9, 9, 9, 9]),
                        new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                    ]
                ],
            ];
    }

    /**
     * @dataProvider parseMultipleProvider
     */
    public function testParseMultiple(string $accountNumber, array $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->accountNumberParser->parseMultiple($accountNumber));
    }

}
