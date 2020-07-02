<?php
declare(strict_types = 1);

namespace Cpaas\Helper;

/**
 * Class Helper
 * @package Cpaas\Helper
 */
class Helper
{
    /** Configuration folder name */
    const CONFIG_FOLDER = 'config';
    /** File extension */
    const FILE_EXTENSION = '.php';

    /**
     * @param string $configName
     * @return array
     */
    public static function getConfigByName(string $configName): array
    {
        return include $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.self::CONFIG_FOLDER.DIRECTORY_SEPARATOR.$configName.self::FILE_EXTENSION;
    }

    /**
     * @param string $json
     * @return array
     */
    public static function getValueFromJson(string $json): array
    {
        return json_decode($json, true);
    }

    /**
     * @param array $data
     * @return string
     */
    public static function getValueAsJson(array $data): string
    {
        return json_encode($data);
    }
}