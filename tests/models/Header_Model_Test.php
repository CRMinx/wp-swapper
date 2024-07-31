<?php

namespace WP_Swapper\Tests\Models;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Models\Header;

/**
 * Class for testing the header model
 *
 * @since 0.0.1
 */
class Header_Model_Test extends TestCase {

    /**
     * This model should extract the header tag
     *
     * @since 0.0.1
     */
    public function testExtractContent() {
        $html = '<html><head></head><body><header class="test-class">Header Content</header></body></html>';
        $header_model = new Header($html);

        $expectedContent = '<header class="test-class">Header Content</header>';
        $this->assertSame($expectedContent, $header_model->getContent(), 'Extracted content should match the expected <header> tag.');
    }

    /**
     * Empty header tag should be extracted
     *
     * @since 0.0.1
     */
    public function testExtractContentEmptyHeader() {
        $html = '<html><head></head><body><header></header></body></html>';
        $header_model = new Header($html);

        $expectedContent = '<header></header>';
        $this->assertSame($expectedContent, $header_model->getContent(), 'Extracted content should match the expected <header> tag.');
    }

    /**
     * No header tag should return an empty string
     *
     * @since 0.0.1
     */
    public function testExtractContentNoHeader() {
        $html = '<html><head></head><body><div>No Header Tag</div></body></html>';
        $header_model = new Header($html);

        $expected_content = '';
        $this->assertSame($expected_content, $header_model->getContent(), 'Extracted content should return an empty string.');
    }
}

