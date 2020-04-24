<?php

namespace NumbersTranslator\Classes;

use NumbersTranslator\Interfaces\IPrepareData;

/**
 * Class PrepareData
 * @package NumbersTranslator\Classes
 */
class PrepareData implements IPrepareData
{
    /**
     * @var
     */
    private $number;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $number
     * @return PrepareData
     */
    public static function set(int $number): IPrepareData
    {
        return new static($number);
    }

    /**
     * PrepareData constructor.
     * @param $number
     */
    private function __construct(int $number)
    {
        $this->number = $number;
    }

    /**
     * @return array
     */
    public function get_data(): array
    {
        return $this->prepare();
    }

    /**
     * @return array
     */
    private function prepare(): array
    {
        $string_number = number_format($this->number, 0, '', ' ');
        $this->data['numeric_groups'] = explode(' ', $string_number);
        $this->data['count_numeric_groups'] = count($this->data['numeric_groups']);

        return $this->data;
    }
}