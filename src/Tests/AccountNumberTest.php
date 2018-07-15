<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\AccountNumber;
use PHPUnit\Framework\TestCase;

class AccountNumberTest extends TestCase
{
    public function constructProvider(): array
    {
        return
            [
                [[0, 0, 0, 0, 0, 0, 0, 5, 1]],
                [[4, 5, 7, 5, 0, 8, 0, 0, 0]],
                [[3, 4, 5, 8, 8, 2, 8, 6, 5]],
                [[0, 0, 0, 0, 0, 0, 0, 5, 7]],
                [[6, 6, 4, 3, 7, 1, 4, 9, 5]],
                [[8, 6, 1, 1, 0, null, 2, 3, 6]],
                [[null, null, null, null, null, null, null, null, null]],
            ];
    }

    /**
     * @dataProvider constructProvider
     */
    public function testConstruct(array $digits): void
    {
        $accountNumber = new AccountNumber($digits);

        $this->assertEquals($digits, $accountNumber->getDigits());
    }

    public function constructFailProvider(): array
    {
        return
            [
                [[]],
                [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9]],
                [[0, 1, 2, 3, '4', 5, 6, 7, 8]],
                [[0, 1, 2, 3, 'test' => 4, 5, 6, 7, 8]],
                [[0, 1, 2, 3, 9 => 4, 5, 6, 7, 8]],
                [[6, 6, 4, 3, 7, 1, 10, 9, 5]],
                [[-1, 6, 4, 3, 7, 1, 45, 9, 5]],
            ];
    }

    /**
     * @expectedException \KataBankOCR\Exception\InvalidAccountNumberException
     * @dataProvider constructFailProvider
     */
    public function testCalculateFailIfInvalidArgument(array $digits): void
    {
        new AccountNumber($digits);
    }

    public function hasIllegibleCharactersProvider(): array
    {
        return
            [
                [new AccountNumber([0, 0, 0, 0, 0, 0, 0, 0, 0]), false],
                [new AccountNumber([1, 2, 3, 4, 5, 6, 7, 8, 9]), false],
                [new AccountNumber([8, 6, 1, 1, 0, null, 2, 3, 6]), true],
                [new AccountNumber([null, null, null, null, null, null, null, null, null]), true],
            ];
    }

    /**
     * @requires
     * @dataProvider hasIllegibleCharactersProvider
     */
    public function testHasIllegibleCharacters(AccountNumber $accountNumber, bool $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $accountNumber->hasIllegibleCharacters());
    }
}
