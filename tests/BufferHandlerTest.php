<?php

namespace WP_Swapper\Tests;

use WP_Swapper\BotDetector;
use WP_Swapper\BufferHandler;
use WP_Swapper\ContentProcessor;
use Mockery;

/**
* Tests for Buffer Handler class
*
* @since 0.0.1
*/
class BufferHandlerTest extends TestCase
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
        $botDetector = Mockery::mock(BotDetector::class);
        $botDetector->shouldReceive('is_bot')->andReturn($isBot);
        return $botDetector;
    }

    /**
     * Create mock of Content processor
     *
     * @since 0.0.1
     *
     * @param string $processContent the content that
     * the content processor will return for testing
     *
     * @return ContentProcessor
     */
    private function mockContentProcessor($processedContent)
    {
        $contentProcessor = Mockery::mock(ContentProcessor::class);
        $contentProcessor->shouldReceive('process_content')->andReturn($processedContent);
        return $contentProcessor;
    }

    /**
     * Ensure hooks are added when user is not a search
     * engine bot
     *
     * @since 0.0.1
     */
    public function testConstructorAddsHooksWhenNotBot()
    {
        $botDetector = $this->mockBotDetector(false);
        $contentProcessor = $this->mockContentProcessor('processed content');

        $bufferHandler = new BufferHandler($botDetector, $contentProcessor);
        $this->assertNotFalse(has_action('template_redirect', [$bufferHandler, 'start_output_buffer']));
        $this->assertNotFalse(has_action('wp_print_footer_scripts', [$bufferHandler, 'end_output_buffer']));
    }

    /**
    * Testing for no hooks added when bot User Agent exists
    *
    * @since 0.0.1
    */
    public function testConstructorDoesNotAddHooksWhenBot()
    {
        $botDetector = $this->mockBotDetector(true);
        $contentProcessor = $this->mockContentProcessor('processed content');

        $bufferHandler = new BufferHandler($botDetector, $contentProcessor);
        $this->assertNotTrue(has_action('template_redirect', [$bufferHandler, 'start_output_buffer']));
        $this->assertNotTrue(has_action('wp_print_footer_scripts', [$bufferHandler, 'end_output_buffer']));
    }

    /**
     * Testing for buffer to start
     *
     * @since 0.0.1
     */
    public function testStartOutputBuffer()
    {
        $botDetector = $this->mockBotDetector(false);
        $contentProcessor = $this->mockContentProcessor('processed content');
        $bufferHandler = new BufferHandler($botDetector, $contentProcessor);

        $bufferHandler->start_output_buffer();

        echo 'test content';

        $this->assertTrue(ob_get_length() > 0);

        ob_end_clean();
    }

    /**
    * PHP Unit no support for method closing buffers
    * test case must close its own buffer.
    * public function testEndOutputBuffer()
    * {
    *    $botDetector = $this->mockBotDetector(false);
    *
    *    $contentProcessor = $this->mockContentProcessor('processed content');
    *    $bufferHandler = new BufferHandler($botDetector, $contentProcessor);
    *
    *    ob_start();
    *    echo 'original content';
    *    $bufferHandler->end_output_buffer();
    *
    *    $output = ob_get_clean();
    *    var_dump(ob_get_level()); <- returning 0, yet throwing risky test error.
    *
    *    $this->assertEquals('processed content', $output);
    * }
    */
}
