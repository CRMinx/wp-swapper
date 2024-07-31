<?php

namespace WP_Swapper\Tests\Controllers;

use WP_Swapper\Controllers\Footer_Controller;

/**
* Class for testing the Footer Controller
*
* @since 0.0.1
*/
class Footer_Controller_Test extends Base_Controller_Test {
    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content = '<footer>Initial Content</footer>';

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content = '<footer>Updated Content</footer>';

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the header
    */
    protected $component_name = 'Footer';

    /**
    * Provide the Footer_Controller class for testing
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return Footer_Controller
    */
    protected function get_controller($content) {
        return new Footer_Controller($content);
    }
    /**
    * Test the returned view of footer component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $controller = new Footer_Controller($this->initial_content);

        if ($controller->render() !== '') {
            $expectedId = 'id="changed-footer"';
            $this->assertStringContainsString($expectedId, $controller->render(), 'View should contain the correct Id');
        }
    }
}
