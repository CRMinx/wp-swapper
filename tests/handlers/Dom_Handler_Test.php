<?php

namespace WP_Swapper\Tests\Handlers;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

/**
* Dom_Handler trait tests
*
* @since 0.0.1
*/
class Dom_Handler_Test extends TestCase {

    use Dom_Handler;

    /**
    * Test swapping links with HTMX requests
    *
    * @since 0.0.1
    */
    public function testSwapLinks() {
        $html = '<div><a href="example1.html">Link 1</a><a href="example2.html">Link 2</a></div>';
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $this->swap_links($dom);

        $links = $dom->getElementsByTagName('a');

        $this->assertSame('example1.html', $links->item(0)->getAttribute('hx-get'));
        $this->assertSame('true', $links->item(0)->getAttribute('hx-push-url'));
        $this->assertSame('example2.html', $links->item(1)->getAttribute('hx-get'));
        $this->assertSame('true', $links->item(1)->getAttribute('hx-push-url'));
    }

    /**
    * Test for creating HTMX wrapper around content
    *
    * @since 0.0.1
    */
    public function testCreateWrapper() {
        $content = '<header>Header Content</header><div>Main Content</div><footer>Footer Content</footer>';

        $wrappedContent = $this->create_wrapper($content);
        $expectedContent = '<header>Header Content</header><div id="swapper-loader"><div>Loading...</div><div id="swapper-site-content" hx-boost="true"><div>Main Content</div></div></div><footer>Footer Content</footer>';

        $this->assertSame($expectedContent, $wrappedContent);
    }

    /**
    * Test removing elements around content
    *
    * @since 0.0.1
    */
    public function testRemoveContentWrapper() {
        $content = '<header>Header Content</header><div id="swapper-loader"><div>Loading...</div><div id="swapper-site-content" hx-boost="true"><div>Main Content</div></div></div><footer>Footer Content</footer>';

        $unwrapped_content = $this->remove_content_wrapper($content);
        $expected_content = '<div>Main Content</div>';

        $this->assertSame($expected_content, $unwrapped_content);
    }
}
