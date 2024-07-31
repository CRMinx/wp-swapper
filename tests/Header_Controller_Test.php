<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Header_Controller;

/**
* Class for testing the Header Controller
*
* @since 0.0.1
*/
class Header_Controller_Test extends Base_Controller_Test {
    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content = '<header>Initial Content</header>';

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content = '<header>Updated Content</header>';

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the header
    */
    protected $component_name = 'Header';

    /**
    * Provide the Header_Controller class for testing
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return Header_Controller
    */
    protected function get_controller($content) {
        return new Header_Controller($content);
    }
    /**
    * Test the returned view of header component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $controller = new Header_Controller($this->initial_content);

        if ($controller->render() !== '') {
            $expectedId = 'id="changed-header"';
            $this->assertStringContainsString($expectedId, $controller->render(), 'View should contain the correct Id');
        }
    }
}
