<?php

namespace WP_Swapper\Tests;

use WP_Swapper\BotDetector;

/**
* Bot Detector Class
*
* @since 0.0.1
*/
class BotDetectorTest extends TestCase
{
    /**
    * Reset user agent on setup
    *
    * @since 0.0.1
    */
    protected function setUp(): void
    {
        parent::setUp();
        unset($_SERVER['HTTP_USER_AGENT']);
    }

    /**
    * Reset user agent on teardown
    *
    * @since 0.0.1
    */
    protected function tearDown(): void
    {
        unset($_SERVER['HTTP_USER_AGENT']);
        parent::tearDown();
    }

    /**
    * Detect no bots with known user agent
    *
    * @since 0.0.1
    */
    public function testIsBotWithUnknownUserAgent()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';

        $botDetector = new BotDetector();
        $this->assertFalse($botDetector->is_bot());
    }

    /**
    * Detect no bot with no user agent
    *
    * @since 0.0.1
    */
    public function testIsBotWithEmptyUserAgent()
    {
        $_SERVER['HTTP_USER_AGENT'] = '';

        $botDetector = new BotDetector();
        $this->assertFalse($botDetector->is_bot());
    }

    /**
    * Detect search engine bot user agent
    *
    * @since 0.0.1
    */
    public function testIsBotWithAnotherKnownBotUserAgent()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)';

        $botDetector = new BotDetector();
        $this->assertTrue($botDetector->is_bot());
    }
}
