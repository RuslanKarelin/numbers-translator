<?php

namespace NumbersTranslator\Interfaces;

/**
 * Interface IValidator
 * @package NumbersTranslator\Interfaces
 */
interface IValidator
{
    /**
     * @param $number
     * @return mixed
     */
    public static function validate(int $number): bool;
}