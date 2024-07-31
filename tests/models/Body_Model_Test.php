<?php

namespace WP_Swapper\Tests\Models;

use WP_Swapper\Tests\TestCase;
use WP_Swapper\Models\Body;

/**
* Class for testing the body model
*
* @since 0.0.1
*/
class Body_Model_Test extends TestCase {

    /**
    * This model should extract the starting body tag
    *
    * @since 0.0.1
    */
    public function testExtractContent() {
        $html = '<html><head></head><body class="test-class">Initial Content</body></html>';
        $body_model = new Body($html);

        $expectedContent = '<body class="test-class">';
        $this->assertSame($expectedContent, $body_model->getContent(), 'Extracted content should match the expected <body> tag.');
    }

    /**
    * Empty body tag should be extracted
    *
    * @since 0.0.1
    */
    public function testExtractContentEmptyBody() {
        $html = '<html><head></head><body></body></html>';
        $body_model = new Body($html);

        $expectedContent = '<body>';
        $this->assertSame($expectedContent, $body_model->getContent(), 'Extracted content should match the expected <body> tag.');
    }

    /**
    * No body tag should return an empty string
    *
    * @since 0.0.1
    */
    public function testExtractContentNoBody() {
        $html = '<html><head></head><div>No Body Tag</div></html>';
        $body_model = new Body($html);

        $expected_content = '';
        $this->assertSame($expected_content, $body_model->getContent(), 'Extracted content should return an empty string.');
    }
}
