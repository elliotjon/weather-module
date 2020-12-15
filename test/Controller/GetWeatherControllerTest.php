<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the GeoWeatherController.
 */
class GeoWeatherControllerTest extends TestCase
{

    // Create the di container.
    // protected $di;
    // protected $controller;



    /**
     * Setup di
     * Set directory to a test cache.
     */
    protected function setUp()
    {
        global $di;

        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $di = $this->di;

        // intitialie the controller
        $this->controller = new GeoWeatherController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testIndexActionGet()
    {
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();
        $exp = "Weather forecast";
        $this->assertContains($exp, $body);
    }

    public function testIndexActionPostWithValidIPV4()
    {
        $_POST["geo"] = "8.8.4.4";
        $_POST["weather"] = "future";

        $res = $this->controller->indexActionPost();
        $body = $res->getBody();

        $exp = "This is the <b>future</b> weather forecast for:";
        $this->assertContains($exp, $body);
        $exp = "America/Los_Angeles";
        $this->assertContains($exp, $body);
        $exp = "1350, Shorebird Way, Shoreline Business Park, Mountain View, Santa Clara County, California, 94043, United States";
        $this->assertContains($exp, $body);
    }

    public function testIndexActionPostWithValidIPV6()
    {
        $_POST["geo"] = "2607:f0d0:1002:51::4";
        $_POST["weather"] = "past";
        $res = $this->controller->indexActionPost();
        $body = $res->getBody();
        $exp = "This is the <b>past</b> weather forecast for:";
        $this->assertContains($exp, $body);
        $exp = "America/Chicago";
        $this->assertContains($exp, $body);
    }

    public function testIndexActionPostValidCoordinates()
    {
        $_POST["geo"] = "47.4925,19.0513";
        $_POST["weather"] = "future";
        $res = $this->controller->indexActionPost();
        $body = $res->getBody();
        $exp = "Weather forecast";
        $this->assertContains($exp, $body);
        $exp = "Europe/Budapest";
        $this->assertContains($exp, $body);
    }
    public function testIndexActionPostInvalidAmountCoordinates()
    {
        $_POST["geo"] = "47,19,4";
        $_POST["weather"] = "future";
        $res = $this->controller->indexActionPost();
        $body = $res->getBody();
        $exp = "Weather forecast";
        $this->assertContains($exp, $body);
        $exp = "Something went wrong when trying to curl the weather...";
        $this->assertContains($exp, $body);
    }
    public function testIndexActionPostInvalidOutOfRangeCoordinates()
    {
        $_POST["geo"] = "180.4925,200.0513";
        $_POST["weather"] = "past";
        $res = $this->controller->indexActionPost();
        $body = $res->getBody();
        $exp = "Weather forecast";
        $this->assertContains($exp, $body);
        $exp = "Something went wrong when trying to curl the weather...";
        $this->assertContains($exp, $body);
    }

      /**
     * Test JSON
     */
    public function testJsonAction()
    {
        $res = $this->controller->jsonAction();
        $this->assertIsObject($res);
    }

    /**
     * Test JSON, POST
     */
    public function testJsonActionPostWithValidIPv4()
    {
        $_POST["geo"] = "8.8.4.4";
        $_POST["weather"] = "future";
        $res = $this->controller->jsonActionPOST();
        $exp = '{"data":{"latitude":';
        $this->assertContains($exp, $res);
    }
    /**
     * Test JSON, POST
     */
    public function testJsonActionPostWithValidCoordinates()
    {
        $_POST["geo"] = "47.4925,19.0513";
        $_POST["weather"] = "future";
        $res = $this->controller->jsonActionPOST();
        $exp = '{"data":{"latitude":';
        $this->assertContains($exp, $res);
    }
    /**
     * Test JSON, POST
     */
    public function testJsonActionPostWithInvalidAmount()
    {
        $_POST["geo"] = "47,19,4";
        $_POST["weather"] = "future";
        $res = $this->controller->jsonActionPOST();
        $exp = "";
        $this->assertContains($exp, $res);
    }
    /**
     * Test JSON, POST
     */
    public function testJsonActionPostWithInvalidLocation()
    {
        $_POST["geo"] = "180.4925,200.0513";
        $_POST["weather"] = "past";
        $res = $this->controller->jsonActionPOST();
        $exp = "";
        $this->assertContains($exp, $res);
    }
}
