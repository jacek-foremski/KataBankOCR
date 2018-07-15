<?php
declare(strict_types=1);

namespace KataBankOCR\Exception;

class ParseException extends \Exception implements KataBankOCRException
{
    public function __construct(string $string)
    {
        parent::__construct(sprintf('String "%s" could not be parsed', $string));
    }
}
