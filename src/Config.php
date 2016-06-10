<?php
/**
 * Manages configuration per environment and enforces existence of configurations
 */

namespace robotdance;

/**
 * Manages configuration per environment and enforces existence of configurations
 */
class Config
{
    private static $configFile = './config/config.yml';

    /**
     * Sets where to look for the configuration file.
     * Defaults to './config.yml'
     * @param $path the full path
     * @return String returns the same value if success
     */
    public static function setConfigFile($path)
    {
        if (!(is_file($path) && is_readable($path))) {
            throw new \InvalidArgumentException("File not found or without reading permission: $path");
        }
        self::$configFile = $path;
        return self::$configFile;
    }

    /**
     * @param  $key
     * @return String Value
     */
    public static function getEnvVar($key, $enforceEnvironment = true)
    {
        $value = getenv($key);
        if ($value === false && $enforceEnvironment) {
            throw new \InvalidArgumentException("Environment variable '$key' not found.");
        }
        return $value;
    }

    /**
     * Return configuration value
     * @param  $key
     * @return String Value
     */
    public static function get($key, $enforceEnvironment = true)
    {
        $env = self::getEnvVar('ENVIRONMENT', $enforceEnvironment);
        $yml = yaml_parse_file(self::$configFile);
        if (is_array($yml[$key]) && array_key_exists($env, $yml[$key])) {
            return $yml[$key][$env];
        }
        return $yml[$key];
    }
}
