<?php

namespace robotdance;

use robotdance\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        putenv('ENVIRONMENT=test');
    }

    public function tearDown()
    {
        putenv('ENVIRONMENT'); // = unset
    }

    /**
     * Must return the default configuration
     */
    public function testGetConfigFileDefault()
    {
        $expected = getcwd() . "/config/config.yml";
        $actual = Config::getConfigFile();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Must throw exception if there is no config file
     * @expectedException InvalidArgumentException
     */
    public function testSetConfigFileNonExistant()
    {
        Config::setConfigFile('file_that_not_exists.yml');
    }

    /**
     * Must return the same value passed if success
     */
    public function testSetConfigFileReturnSame()
    {
        $path = getcwd() . "/config/config.yml";
        $this->assertEquals(Config::setConfigFile("/config/config.yml"), $path);
    }

    /**
     * Must throw exception it there is no key
     * @expectedException PHPUnit_Framework_Error
     */
    public function testGetEnvMustTrowExceptionWhenThereIsNoKey()
    {
        Config::get('some_setting_xxx');
    }

    /**
     * Must throw exception if there is no environment defined
     * @expectedException PHPUnit_Framework_Error
     */
    public function testGetEnvMustTrowExceptionWhenThereIsNoEnvironment()
    {
        putenv('ENVIRONMENT'); // = unset
        Config::get('some_setting');
    }

    /**
     * Must return a value
     */
    public function testGetValidWithEnvironment()
    {
        $value = Config::get('some_setting');
        $this->assertNotEmpty($value);

        putenv('ENVIRONMENT=development');
        $value = Config::get('some_setting');
        $this->assertNotEmpty($value);

        putenv('ENVIRONMENT=prodution');
        $value = Config::get('some_setting');
        $this->assertNotEmpty($value);
    }

    /**
     * Must return a value even without environment
     */
    public function testGetValidWithoutEnvironment()
    {
        $value = Config::get('another_setting');
        $this->assertEquals('another setting without environment', $value);
    }
}
