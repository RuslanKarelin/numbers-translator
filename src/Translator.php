<?php

namespace NumbersTranslator;

use NumbersTranslator\Classes\DataStorage;
use NumbersTranslator\Classes\PrepareData;
use NumbersTranslator\Classes\Engine;
use NumbersTranslator\Classes\Validator;


/**
 * Class Translator
 * @package NumbersTranslator
 */
class Translator
{
    /**
     * @param $number
     * @param string $lang
     * @return string
     */
    public static function make(int $number, string $lang = 'uk'): string
    {
        if (!Validator::validate($number)) {
            throw new \InvalidArgumentException('Invalid characters are present or a number greater than 16 characters!');
        }

        $engine = new Engine(
            PrepareData::set($number),
            DataStorage::get(),
            $lang
        );

        return $engine->run();
    }

    /**
     * Translator constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}