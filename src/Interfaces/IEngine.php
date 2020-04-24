<?php

namespace NumbersTranslator\Interfaces;

/**
 * Interface IEngine
 * @package NumbersTranslator\Interfaces
 */
interface IEngine
{
    /**
     * @return mixed
     */
    public function run(): string;
}