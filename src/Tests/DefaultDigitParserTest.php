<?php
declare(strict_types=1);

namespace KataBankOCR\Tests;

use KataBankOCR\DefaultDigitParser;
use PHPUnit\Framework\TestCase;

class DefaultDigitParserTest extends TestCase
{
    /**
     * @var DefaultDigitParser
     */
    private $digitParser;

    public function setUp()
    {
        $this->digitParser = new DefaultDigitParser();
    }

    public function parseProvider(): array
    {
        return
            [
                [
                    ' _ ' .
                    '| |' .
                    '|_|' .
                    '   ', 0],
                [
                    '   ' .
                    '  |' .
                    '  |' .
                    '   ', 1],
                [
                    ' _ ' .
                    ' _|' .
                    '|_ ' .
                    '   ', 2],
                [
                    ' _ ' .
                    ' _|' .
                    ' _|' .
                    '   ', 3],
                [
                    '   ' .
                    '|_|' .
                    '  |' .
                    '   ', 4],
                [
                    ' _ ' .
                    '|_ ' .
                    ' _|' .
                    '   ', 5],
                [
                    ' _ ' .
                    '|_ ' .
                    '|_|' .
                    '   ', 6],
                [
                    ' _ ' .
                    '  |' .
                    '  |' .
                    '   ', 7],
                [
                    ' _ ' .
                    '|_|' .
                    '|_|' .
                    '   ', 8],
                [
                    ' _ ' .
                    '|_|' .
                    ' _|' .
                    '   ', 9],
                [
                    '|||' .
                    '|||' .
                    '|||' .
                    '   ', null],
                [
                    '   ' .
                    '   ' .
                    '   ' .
                    '   ', null],
                [
                    ' s ' .
                    ' _|' .
                    '|_ ' .
                    '   ', null],
                [
                    ' | ', null],
            ];
    }

    /**
     * @dataProvider parseProvider
     */
    public function testParse(string $digit, ?int $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, $this->digitParser->parse($digit));
    }
}
