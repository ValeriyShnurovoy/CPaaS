<?php
declare(strict_types = 1);

namespace Cpaas\Service;

use Cpaas\Helper\Helper;
use Cpaas\Transport\CurlTransport;

/**
 * Class RouteeService
 * @package Cpaas\Service
 */
class RouteeService
{
    /** Routee auth config */
    const AUTH_CONFIG_NAME = 'routeeAuth';

    /** Routee sms config */
    const SMS_CONFIG_NAME = 'routeeSms';

    /** Phone number for low temperature */
    const PHONE_NUMBER_LOW_TEMP = '+306948872100';

    /** Phone number for high temperature */
    const PHONE_NUMBER_HIGH_TEMP = '+306948872100';

    /**
     * Main function
     *
     * @param float $temperature
     */
    public function sendSms(float $temperature): void
    {
        $token = $this->auth();
        $this->createSms($temperature, $token);
    }

    /**
     * Get authorization token from Potsee
     *
     * @return null|string
     */
    protected function auth():?string
    {
        $token = '';
        try {
            $config = $this->getAuthConfig();
            $curlTransport = new CurlTransport();
            $response = $curlTransport->getData($config);
            $result = Helper::getValueFromJson($response);
            if (isset($result['access_token'])) {
                $token= $result['access_token'];
            } else {
                throw new \Exception("The token has not returned");
            }
        } catch (\Exception $e) {
                echo $e->getMessage();
        }
        return $token;
    }

    /**
     * Create and send SMS
     *
     * @param float $temperature
     * @param string $token
     */
    protected function createSms(float $temperature, string $token):void
    {
        try {
            $config = $this->getSmsConfig($temperature, $token);
            $curlTransport = new CurlTransport();
            $result = $curlTransport->getData($config);
            var_export($result);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Prepare auth config
     *
     * @return array
     * @throws \Exception
     */
    protected function getAuthConfig(): array
    {
        //get config from file
        $config = Helper::getConfigByName(self::AUTH_CONFIG_NAME);

        //prepare config for authorization
        if (isset($config['applicationId'])) {

            $authKey = $config['applicationId'];

            if (isset($config['secret'])) {

                $authKey .= ':' . $config['secret'];
                $config['headers'][] = 'Authorization:Basic ' . base64_encode($authKey);

            } else {
                throw new \Exception("Secret key is missing");
            }
        } else {
            throw new \Exception("Application id is missing");
        }

        return $config;
    }

    /**
     * Prepare config for sending sms
     *
     * @param float $temperature
     * @param string $token
     * @return array
     */
    protected function getSmsConfig(float $temperature, string $token): array
    {
        //get config from file
        $config = Helper::getConfigByName(self::SMS_CONFIG_NAME);

        //prepare config for send sms
        if (!empty($token)) {
            $config['headers'][] = 'authorization: Bearer ' . $token;
            $config['json'] = Helper::getValueAsJson([
                'body' => $this->getBodyByTemp($temperature),
                'to' => $this->getPhoneNumberByTemp($temperature),
                'from' => 'VShnurovoy',
            ]);
        }

        return $config;
    }

    /**
     * Get text for sms by temperature
     *
     * @param float $temperature
     * @return string
     */
    protected function getBodyByTemp(float $temperature): string
    {
        $body = 'Valera Shnurovoy and Temperature ';
        if ($temperature >= 20) {
            $body .= 'more';
        } else {
            $body .= 'less';
        }
        $body .= ' than 20C. The actual temperature: ' . $temperature . 'C';
        return $body;
    }

    /**
     * Get phone number by temperature
     *
     * @param float $temperature
     * @return string
     */
    protected function getPhoneNumberByTemp(float $temperature): string
    {
        $phone = self::PHONE_NUMBER_LOW_TEMP;
        if ($temperature >= 20) {
            $phone = self::PHONE_NUMBER_HIGH_TEMP;
        }
        return $phone;
    }

}