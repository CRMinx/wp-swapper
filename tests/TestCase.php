<?php

namespace WP_Swapper\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Functions;

/**
* Parent test case class
*
* @since 0.0.1
*/
class TestCase extends PHPUnitTestCase
{
    use MockeryPHPUnitIntegration;

    /**
    * set up parent and monkey
    * define WP functions that are undefined without WP core.
    *
    * @since 0.0.1
    */
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();

        Functions\when('esc_url')->returnArg();
        Functions\when('wp_swapper_get_loading_icon')->justReturn('<div>Loading...</div>');
    }

    /**
    * tear down parent and monkey
    *
    * @since 0.0.1
    */
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
