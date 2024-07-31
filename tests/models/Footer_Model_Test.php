<?php

namespace WP_Swapper\Tests\Models;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Models\Footer;

/**
 * Class for testing the footer model
 *
 * @since 0.0.1
 */
class Footer_Model_Test extends TestCase {

    /**
     * This model should extract the footer tag
     *
     * @since 0.0.1
     */
    public function testExtractContent() {
        $html = '<html><head></head><body><footer class="test-class">Footer Content</footer></body></html>';
        $footer_model = new Footer($html);

        $expectedContent = '<footer class="test-class">Footer Content</footer>';
        $this->assertSame($expectedContent, $footer_model->getContent(), 'Extracted content should match the expected <footer> tag.');
    }

    /**
     * Empty footer tag should be extracted
     *
     * @since 0.0.1
     */
    public function testExtractContentEmptyFooter() {
        $html = '<html><head></head><body><footer></footer></body></html>';
        $footer_model = new Footer($html);

        $expectedContent = '<footer></footer>';
        $this->assertSame($expectedContent, $footer_model->getContent(), 'Extracted content should match the expected <footer> tag.');
    }

    /**
     * No footer tag should return an empty string
     *
     * @since 0.0.1
     */
    public function testExtractContentNoFooter() {
        $html = '<html><head></head><body><div>No Footer Tag</div></body></html>';
        $footer_model = new Footer($html);

        $expected_content = '';
        $this->assertSame($expected_content, $footer_model->getContent(), 'Extracted content should return an empty string.');
    }
}

