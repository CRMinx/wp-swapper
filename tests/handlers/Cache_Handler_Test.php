<?php

namespace WP_Swapper\Tests\Handlers;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Traits\Cache_Handler;

/**
* Cache Handler Tests
*
* @since 0.0.1
*/
class Cache_Handler_Test extends TestCase {

    use Cache_Handler;

    /**
    * Mock html content
    *
    * @since 0.0.1
    *
    * @var string
    */
    private $content = '<div>Test Content</div>';

    /**
    * Mock session key
    *
    * @since 0.0.1
    *
    * @var string
    */
    private $key = 'test_component';

    /**
    * Initialize empty $_SESSION array
    *
    * @since 0.0.1
    */
    protected function setUp(): void {
        parent::setUp();
        $_SESSION = [];
    }

    /**
    * Clean up $_SESSION array after test completion
    *
    * @since 0.0.1
    */
    protected function tearDown(): void {
        $_SESSION = [];
        parent::tearDown();
    }

    /**
    * Component should be cached.
    *
    * @since 0.0.1
    */
    public function testCacheComponent() {
        $this->cacheComponent($this->key, $this->content);
        $this->assertSame($this->content, $_SESSION[$this->key], 'Cached content should match the expected content.');
    }

    /**
    * Test getting cached content
    *
    * @since 0.0.1
    */
    public function testGetCachedComponent() {
        $_SESSION[$this->key] = $this->content;

        $cached_content = $this->getCachedComponent($this->key);
        $this->assertSame($this->content, $cached_content, 'Retrieved cached content should match the expected content.');
    }

    /**
    * Test checking if component has changed.
    *
    * @since 0.0.1
    */
    public function testHasComponentChanged() {
        $newContent = '<div>New Content</div>';
        $_SESSION[$this->key] = $this->content;

        $this->assertTrue($this->hasComponentChanged($this->key, $newContent), 'Component should be marked as changed.');
        $this->assertFalse($this->hasComponentChanged($this->key, $this->content), 'Component should not be marked as changed.');
    }

    /**
    * Mock normalizeContent function to satisfy
    * abstract method in Cache_Handler
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return string $content
    */
    protected function normalizeContent($content) {
        return $content;
    }
}
