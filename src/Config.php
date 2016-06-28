<?php
/**
 * Manages configuration per environment and enforces existence of configurations
 */

namespace robotdance;

use Symfony\Component\Yaml\Yaml;

/**
 * Manages configuration per environment and enforces existence of configurations
 */
class Config
{
    private static $configFile;

    /**
     * Sets where to look for the configuration file.
     * Defaults to './config.yml'
     * @param $path the full path
     * @return String returns the same value if success
     */
    public static function setConfigFile($path)
    {
        self::$configFile = getcwd() . $path;
        if (!(is_file(self::getConfigFile()) && is_readable(self::getConfigFile()))) {
            throw new \InvalidArgumentException("File not found or without reading permission: $path");
        }
        return self::$configFile;
    }

    /**
     * Returns the config file path
     * @return The config.yml file path
     */
    public static function getConfigFile()
    {
        if(self::$configFile === null) {
            self::$configFile = getcwd() . '/config/config.yml';
        }
        return self::$configFile;
    }

    /**
     * Returns a configuration value at /config/config.yml
     * @param  $key
     * @return String Value
     */
    public static function get($key)
    {
        $env = getenv('ENVIRONMENT');
        $yml = Yaml::parse(file_get_contents(self::getconfigFile()));
        if (is_array($yml[$key]) && array_key_exists($env, $yml[$key])) {
            return $yml[$key][$env];
        }
        return $yml[$key];
    }
}
