<?php

namespace WP_Swapper\Tests\Models;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Models\Scripts;

/**
 * Class for testing the scripts model
 *
 * @since 0.0.1
 */
class Scripts_Model_Test extends TestCase {

    /**
     * This model should extract script tags from the body
     *
     * @since 0.0.1
     */
    public function testExtractContent() {
        $html = '<html><head></head><body><script src="example1.js"></script><script src="example2.js"></script></body></html>';
        $scripts_model = new Scripts($html);

        $expectedContent = '<script src="example1.js"></script><script src="example2.js"></script>';
        $this->assertSame($expectedContent, $scripts_model->getContent(), 'Extracted content should match the expected <script> tags.');
    }

    /**
     * Empty body should return an empty string
     *
     * @since 0.0.1
     */
    public function testExtractContentEmptyBody() {
        $html = '<html><head></head><body></body></html>';
        $scripts_model = new Scripts($html);

        $expectedContent = '';
        $this->assertSame($expectedContent, $scripts_model->getContent(), 'Extracted content should be empty for an empty body.');
    }

    /**
     * No script tags in the body should return an empty string
     *
     * @since 0.0.1
     */
    public function testExtractContentNoScripts() {
        $html = '<html><head></head><body><div>No Scripts Here</div></body></html>';
        $scripts_model = new Scripts($html);

        $expected_content = '';
        $this->assertSame($expected_content, $scripts_model->getContent(), 'Extracted content should be empty if there are no <script> tags in the body.');
    }
}
