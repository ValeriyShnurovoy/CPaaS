<?php
declare(strict_types = 1);

namespace Cpaas\Transport;

/**
 * Class CurlTransport
 * @package Cpaas\Transport
 */
class CurlTransport implements Transport
{
    /**
     * @param array $condition
     *
     * @return null|string
     */
    public function getData(array $condition): ?string
    {
        $result = '';
        try {
            $ch = curl_init();

            if (isset($condition['url'])) {
                if (isset($condition['params'])) {
                    $url = $condition['url'] . '?' . http_build_query($condition['params']);
                } else {
                    $url = $condition['url'];
                }
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            }

            if (isset($condition['post'])) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($condition['post']));
            }

            if (isset($condition['json'])) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $condition['json']);
            }

            if (isset($condition['headers'])) {
                curl_setopt($ch, CURLOPT_HTTPHEADER,  $condition['headers']);
            }

            $result = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
        }

        return $result;
    }
}