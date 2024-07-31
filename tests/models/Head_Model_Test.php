<?php

namespace WP_Swapper\Tests\Models;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Models\Head;

/**
 * Class for testing the head model
 *
 * @since 0.0.1
 */
class Head_Model_Test extends TestCase {

    /**
     * This model should extract the head tag
     *
     * @since 0.0.1
     */
    public function testExtractContent() {
        $html = '<html><head class="test-class"><style>.test { color: red; }</style><script src="example.js"></script></head><body></body></html>';
        $head_model = new Head($html);

        $expectedContent = '<head class="test-class"><style>.test { color: red; }</style><script src="example.js"></script></head>';
        $this->assertSame($expectedContent, $head_model->getContent(), 'Extracted content should match the expected <head> tag.');
    }

    /**
     * Empty head tag should be extracted
     *
     * @since 0.0.1
     */
    public function testExtractContentEmptyHead() {
        $html = '<html><head></head><body></body></html>';
        $head_model = new Head($html);

        $expectedContent = '<head></head>';
        $this->assertSame($expectedContent, $head_model->getContent(), 'Extracted content should match the expected <head> tag.');
    }

    /**
     * No head tag should return an empty string
     *
     * @since 0.0.1
     */
    public function testExtractContentNoHead() {
        $html = '<html><body><div>No Head Tag</div></body></html>';
        $head_model = new Head($html);

        $expected_content = '';
        $this->assertSame($expected_content, $head_model->getContent(), 'Extracted content should return an empty string.');
    }
}

