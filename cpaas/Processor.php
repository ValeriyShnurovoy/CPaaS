<?php
declare(strict_types = 1);

namespace Cpaas;

use Cpaas\Service\OpenWeatherMapService;
use Cpaas\Service\RouteeService;

/**
 * Class Processor
 */
class Processor
{
    /**
     *
     */
    public static function run(): void
    {
        try {
            $openWeather = new OpenWeatherMapService();
            $temperature = $openWeather->getTemperature();
            $routee = new RouteeService();
            $routee->sendSms($temperature);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}