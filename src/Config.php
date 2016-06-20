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
    private static $configFile = '/config/config.yml';

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

    public static function getConfigFile()
    {
        return getcwd() . self::$configFile;
    }

    /**
     * Returns an environment variable value, generating a warning if it does not exists
     * @param  $key The environment variable name
     * @return String Value
     */
    public static function getEnvVar($key)
    {
        $value = getenv($key);
        if ($value === false) {
            trigger_error("Environment variable '$key' not found.", E_USER_WARNING);
        }
        return $value;
    }

    /**
     * Returns a configuration value at /config/config.yml
     * @param  $key
     * @return String Value
     */
    public static function get($key)
    {
        $env = self::getEnvVar('ENVIRONMENT');
        $yml = yaml_parse_file(self::getConfigFile());
        if (is_array($yml[$key]) && array_key_exists($env, $yml[$key])) {
            return $yml[$key][$env];
        }
        return $yml[$key];
    }
}
