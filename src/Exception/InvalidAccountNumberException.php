<?php
declare(strict_types=1);

namespace KataBankOCR\Exception;

class InvalidAccountNumberException extends \InvalidArgumentException implements KataBankOCRException
{
    /**
     * @var array
     */
    public $array;

    public function __construct(array $array)
    {
        $this->array = $array;

        parent::__construct('This function only accepts array of integers or nulls with 9 elements indexed from 0');
    }
}
