<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Handlers\Htmx_Handler;
use Mockery;

/**
* Htmx Handler Test class
*
* @since 0.0.1
*/
class Htmx_Handler_Test extends TestCase
{
    /**
    * Create mock of bot detector
    *
    * @since 0.0.1
    *
    * @param bool $isBot true if User Agent is a search engine bot
    *
    * @return BotDetector
    */
    private function mockBotDetector($isBot)
    {
        $htmxHandler = Mockery::mock('WP_Swapper\Handlers\Htmx_Handler')->makePartial();
        $htmxHandler->shouldReceive('is_bot')->andReturn($isBot);
        return $htmxHandler;
    }

    /**
    * script to see if htmx attributes are added to the body tag
    *
    * @since 0.0.1
    *
    * @param bool $isBot true if User Agent is a search engine bot
    * @param string $expectedOutput should have htmx attributes if user is not a bot
    */
    private function runAddHtmxAttributesToBodyTest($isBot, $expectedOutput)
    {
        $htmxHandler = $this->mockBotDetector($isBot);

        $classes = ['class1', 'class2'];

        ob_start();
        $result = $htmxHandler->add_htmx_attributes_to_body($classes);
        $output = ob_get_clean();

        $this->assertEquals($classes, $result);
        $this->assertEquals($expectedOutput, $output);
    }

    /**
    * Ensure constructor method adds filter on body_class
    *
    * @since 0.0.1
    */
    public function testConstructorAddsFilter()
    {
        $htmxHandler = new Htmx_Handler();
        $this->assertNotFalse(has_filter('body_class', [$htmxHandler, 'add_htmx_attributes_to_body'], 20, 2));
    }

    /**
    * Test to see if htmx attributes are added to body tag
    *
    * @since 0.0.1
    */
    public function testAddHtmxAttributesToBodyWhenNotBot()
    {
        $expectedOutput = ' hx-indicator="#swapper-loader" hx-target="#swapper-site-content" hx-swap="innerHTML show:window:top"';
        $this->runAddHtmxAttributesToBodyTest(false, $expectedOutput);
    }

    /**
    * Test to ensure htmx attributes are not added if
    * search engine bot is visiting
    *
    * @since 0.0.1
    */
    public function testAddHtmxAttributesToBodyWhenBot()
    {
        $this->runAddHtmxAttributesToBodyTest(true, '');
    }
}
