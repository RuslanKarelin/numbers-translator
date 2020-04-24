<?php

namespace NumbersTranslator\Classes;

use NumbersTranslator\Interfaces\IValidator;

/**
 * Class Validator
 * @package NumbersTranslator\Classes
 */
class Validator implements IValidator
{

    /**
     * @param $number
     * @return bool
     */
    public static function validate(int $number): bool
    {
        if (strlen($number) > 16) {
            return false;
        }
        return true;
    }
}