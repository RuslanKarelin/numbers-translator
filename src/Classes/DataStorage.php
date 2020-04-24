<?php

namespace NumbersTranslator\Classes;

/**
 * Class DataStorage
 * @package NumbersTranslator\Classes
 */
class DataStorage
{
    /**
     * @var array
     */
    protected static $storage = [
        'comparison' => [
            '0' => '',
            '1' => [
                '1' => 'one',
                '2' => 'ten',
                '3' => 'one hundred'
            ],
            '2' => [
                '1' => 'two',
                '2' => 'twenty',
                '3' => 'two hundred'
            ],
            '3' => [
                '1' => 'three',
                '2' => 'thirty',
                '3' => 'three hundred'
            ],
            '4' => [
                '1' => 'four',
                '2' => 'forty',
                '3' => 'four hundred'
            ],
            '5' => [
                '1' => 'five',
                '2' => 'fifty',
                '3' => 'five hundred'
            ],
            '6' => [
                '1' => 'six',
                '2' => 'sixty',
                '3' => 'six hundred'
            ],
            '7' => [
                '1' => 'seven',
                '2' => 'seventy',
                '3' => 'seven hundred'
            ],
            '8' => [
                '1' => 'eight',
                '2' => 'eighty',
                '3' => 'eight hundred'
            ],
            '9' => [
                '1' => 'nine',
                '2' => 'ninety',
                '3' => 'nine hundred'
            ],
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
        ],
        'breakdown' => [
            '6' => 'quadrillion',
            '5' => 'trillion',
            '4' => 'billion',
            '3' => 'million',
            '2' => 'thousand',
            '1' => ''
        ]
    ];

    /**
     * @return array
     */
    public static function get(): array
    {
        return static::$storage;
    }

    /**
     * DataStorage constructor.
     */
    private function __construct()
    {
    }


    private function __wakeup()
    {
    }


    private function __clone()
    {
    }
}