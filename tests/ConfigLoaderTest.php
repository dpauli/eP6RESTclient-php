<?php

namespace ep6;

class ConfigLoaderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @group utility
	 */
    function testInputFile()
    {
        $this->assertFalse(ConfigLoader::autoload("thisFileDoesNot.exists"));
        $this->assertFalse(ConfigLoader::autoload("empty.file"));
        $this->assertFalse(ConfigLoader::autoload("noJSON.file"));
        $this->assertTrue(ConfigLoader::autoload("config.json"));
    }
}