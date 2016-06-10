<?php

namespace robotdance;

use robotdance\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    const CONFIG_PATH = './config/config.yml';

    public function setUp()
    {
        putenv('ENVIRONMENT=test');
        Config::setConfigFile(self::CONFIG_PATH);
    }

    public function tearDown()
    {
        putenv('ENVIRONMENT'); // = unset
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
        $path = self::CONFIG_PATH;
        $this->assertEquals(Config::setConfigFile($path), $path);
    }

    /**
     * Must throw exception if var does not exists
     * @expectedException InvalidArgumentException
     */
    public function testGetEnvMustThrowException()
    {
        $bob = Config::getEnvVar('BOB');
    }

    /**
     * Must return null if not enforcing environment
     */
    public function testGetEnvMustReturnNull()
    {
        $bob = Config::getEnvVar('BOB', false);
        $this->assertEquals(null, $bob);
    }

    /**
     * Must return a value
     */
    public function testGetEnvMustReturnValue()
    {
        putenv("BOB=BOB");
        $this->assertEquals(Config::getEnvVar('BOB'), "BOB");
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
     * @expectedException Exception
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
