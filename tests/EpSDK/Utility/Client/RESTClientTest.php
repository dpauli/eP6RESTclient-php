<?php
declare(strict_types=1);
namespace EpSDK\Utility\Client;

use EpSDK\Configuration\Configuration;
use EpSDK\Exception\ConfigurationIncompleteException;
use EpSDK\Exception\ConfigurationNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class RESTClientTest
 *
 * @package EpSDK\Utility\Client
 */
class RESTClientTest extends TestCase
{
    public function testGetWithoutClientConfiguration()
    {
        // GIVEN
        Configuration::setConfiguration(['NotImportant' => 'DoesNotTakeEffect'], 'UselessModule');
        $this->expectException(ConfigurationNotFoundException::class);

        // WHEN / THEN
        RESTClient::get('somePath');
    }

    public function testGetWithoutEnoughConfiguration()
    {
        // GIVEN
        Configuration::setConfiguration(['NotImportant' => 'DoesNotTakeEffect'], 'Client');
        $this->expectException(ConfigurationIncompleteException::class);

        // WHEN / THEN
        RESTClient::get('somePath');
    }
}
