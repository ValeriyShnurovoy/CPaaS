<?php
declare(strict_types = 1);

namespace Cpaas\Transport;

/**
 * Interface Transport
 * @package Cpaas\Transport
 */
interface Transport
{
    /**
     * @param array $condition
     * @return string
     */
    public function getData(array $condition): ?string;
}