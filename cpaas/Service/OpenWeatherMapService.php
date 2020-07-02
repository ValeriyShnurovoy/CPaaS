<?php
declare(strict_types = 1);

namespace Cpaas\Service;

use Cpaas\Helper\Helper;
use Cpaas\Transport\CurlTransport;

/**
 * Class OpenWeatherMapService
 *
 * Get data from openweathermap.org
 *
 * @package Cpaas\Service
 */
class OpenWeatherMapService
{
    /** Config file name */
    const CONFIG_NAME = 'openweathermap';

    /**
     * Get temperature in Thessaloniki
     *
     * @return float
     * @throws \Exception
     */
    public function getTemperature(): float
    {
        $temperature = 0;
        $result = $this->getData();
        if (isset($result['main']['temp'])) {
            $temperature = $result['main']['temp'];
        } else {
            throw new \Exception("The temperature value has not returned");
        }
        return $temperature;
    }

    /**
     * Get data from api.openweathermap.org
     *
     * @return array
     */
    protected function getData(): array
    {
        $curlTransport = new CurlTransport();
        $weatherResponce = $curlTransport->getData(Helper::getConfigByName(self::CONFIG_NAME));
        return Helper::getValueFromJson($weatherResponce);
    }
}