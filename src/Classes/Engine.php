<?php

namespace NumbersTranslator\Classes;

use NumbersTranslator\Interfaces\IEngine;
use NumbersTranslator\Interfaces\IPrepareData;

/**
 * Class Engine
 * @package NumbersTranslator\Classes
 */
class Engine implements IEngine
{

    const FIRST_POSITION = 1;

    const SECOND_POSITION = 2;

    const FIRST_NUMBER = 0;

    const SECOND_NUMBER = 1;

    const THIRD_NUMBER = 2;

    /**
     * @var IPrepareData
     */
    protected $data;

    /**
     * @var
     */
    protected $data_storage;

    /**
     * @var string
     */
    protected $separator;

    /**
     * @var
     */
    protected $lang;

    /**
     * @var string
     */
    protected $result_string = '';


    /**
     * Engine constructor.
     * @param IPrepareData $data
     * @param $data_storage
     * @param $lang
     */
    public function __construct(IPrepareData $data, array $data_storage, string $lang)
    {
        $this->data = $data;
        $this->data_storage = $data_storage;
        $this->separator = ($lang == 'uk') ? ' and ' : ' ';
        $this->lang = $lang;
    }


    protected function start_processing(): void
    {
        $this->data = $this->data->get_data();
    }

    /**
     * @return mixed|string
     */
    public function run(): string
    {
        $this->start_processing();

        foreach ($this->data['numeric_groups'] as $key => $value) {

            $data = '';

            if (strlen($this->data['numeric_groups'][$key]) > 1) {

                if (strlen($this->data['numeric_groups'][$key]) == 3) {
                    $data = $this->for_fist_element($key, $data);
                }

                if (isset($this->data['numeric_groups'][$key][static::THIRD_NUMBER])) {
                    $this->if_count_numbers_three($key, $data);
                } else {
                    $this->if_count_numbers_not_three($key, $data);
                }

            } else {
                $this->for_fist_element($key, $data);
            }

            if (array_sum(str_split($this->data['numeric_groups'][$key])) != 0) {
                $this->result_string .= ' ' . $this->data_storage['breakdown']
                    [$this->data['count_numeric_groups']];
            }

            $this->data['count_numeric_groups']--;
        }

        return $this->postprocessing();
    }


    /**
     * @param $params
     * @return string
     */
    protected function get_from_storage_and_concat(array $params): string
    {
        extract($this->merge_params($params));

        if (is_array($for_search_in_the_storage)) {
            $data = $this->data_storage['comparison'][$this->data['numeric_groups'][$key]
            [$for_search_in_the_storage[static::FIRST_NUMBER]]
            . $this->data['numeric_groups'][$key][$for_search_in_the_storage[static::SECOND_NUMBER]]];

            $params['data'] = $data;
            $this->concatenation_to_string($params);
        } else {
            $data = $this->data_storage['comparison'][$this->data['numeric_groups'][$key][$key_in_storage]];
            $params['data'] = $data;
            $data = $this->concatenation_to_string($params);
        }

        return $data;
    }

    /**
     * @param $params
     * @return string
     */
    protected function concatenation_to_string(array $params): string
    {
        extract($this->merge_params($params));

        $str = '';

        if (is_array($data)) {

            if ($position) {
                $str = ($position == static::FIRST_POSITION) ?
                    '-' . $data[$position] :
                    $this->separator . $data[$position];

                if ($before_zero) {
                    $str = str_replace('-', $this->separator, $str);
                }
            } else {
                $str = ' ' . $data[strlen($this->data['numeric_groups'][$key])];
            }

        } else {

            if (!empty($data)) {
                $str = $not_and ? $data : $this->separator . $data;
            }
        }

        $this->result_string .= $str;

        return '';
    }


    /**
     * @param $key
     * @param $data
     * @return string
     */
    protected function if_count_numbers_three(string $key, string $data): string
    {
        if (array_key_exists($this->data['numeric_groups'][$key][static::SECOND_NUMBER]
            . $this->data['numeric_groups'][$key][static::THIRD_NUMBER], $this->data_storage['comparison'])) {

            $data = $this->get_from_storage_and_concat([
                'key' => $key,
                'data' => $data,
                'for_search_in_the_storage' => [static::SECOND_NUMBER, static::THIRD_NUMBER]
            ]);
        }

        if (empty($data)) {
            $this->get_from_storage_and_concat([
                'key_in_storage' => static::SECOND_NUMBER,
                'key' => $key,
                'data' => $data,
                'position' => static::SECOND_POSITION
            ]);

            $data = $this->data_storage['comparison'][$this->data['numeric_groups'][$key][static::THIRD_NUMBER]];
            $data = $this->data['numeric_groups'][$key][static::SECOND_NUMBER] != 0 ?

                $this->concatenation_to_string([
                    'key' => $key,
                    'data' => $data,
                    'position' => static::FIRST_POSITION
                ]) :

                $this->concatenation_to_string([
                    'key' => $key,
                    'data' => $data,
                    'position' => static::FIRST_POSITION,
                    'before_zero' => true
                ]);
        }

        return $data;
    }

    /**
     * @param $key
     * @param $data
     * @return string
     */
    protected function if_count_numbers_not_three(string $key, string $data): string
    {
        if (array_key_exists($this->data['numeric_groups'][$key][static::FIRST_NUMBER]
            . $this->data['numeric_groups'][$key][static::SECOND_NUMBER], $this->data_storage['comparison'])) {

            $data = $this->get_from_storage_and_concat([
                'key' => $key,
                'data' => $data,
                'position' => null,
                'not_and' => true,
                'for_search_in_the_storage' => [static::FIRST_NUMBER, static::SECOND_NUMBER]
            ]);

        } else {

            if (strlen($this->data['numeric_groups'][$key]) == 2) {
                $data = $this->get_from_storage_and_concat([
                    'key_in_storage' => static::FIRST_NUMBER,
                    'key' => $key,
                    'data' => $data,
                    'position' => static::SECOND_POSITION,
                    'not_and' => true
                ]);

                $data = $this->get_from_storage_and_concat([
                    'key_in_storage' => static::SECOND_NUMBER,
                    'key' => $key,
                    'data' => $data,
                    'position' => static::FIRST_POSITION
                ]);

            } else {
                $data = $this->get_from_storage_and_concat([
                    'key_in_storage' => static::SECOND_NUMBER,
                    'key' => $key,
                    'data' => $data
                ]);
            }
        }

        return $data;
    }

    /**
     * @param $key
     * @param $data
     * @return string
     */
    protected function for_fist_element(string $key, string $data): string
    {
        return $this->get_from_storage_and_concat([
            'key_in_storage' => static::FIRST_NUMBER,
            'key' => $key,
            'data' => $data
        ]);
    }

    /**
     * @return array
     */
    protected function get_params(): array
    {
        return [
            'key_in_storage' => null,
            'key' => null,
            'data' => null,
            'position' => null,
            'not_and' => null,
            'before_zero' => null,
            'for_search_in_the_storage' => null
        ];
    }

    /**
     * @param $array
     * @return array
     */
    protected function merge_params(array $array): array
    {
        return array_merge($this->get_params(), $array);
    }

    /**
     * @return string
     */
    protected function postprocessing(): string
    {
        if (strpos($this->result_string, $this->separator) === 0 && $this->lang == 'uk') {
            $this->result_string = substr($this->result_string, strlen($this->separator), strlen($this->result_string));
        }

        return trim($this->result_string);
    }
}