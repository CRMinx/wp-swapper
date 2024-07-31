<?php

namespace WP_Swapper\Tests\Controllers;

use WP_Swapper\Controllers\Head_Controller;

/**
* Class for testing the head controller
*
* @since 0.0.1
*/
class Head_Controller_Test extends Base_Controller_Test {

    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content = '<html><head><link /></head><body></body></html>';

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content = '<html><head><link /><script></script></head><body></body></html>';

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the header
    */
    protected $component_name = 'Head';

    /**
    * Provide the Head_Controller class for testing
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return Head_Controller
    */
    protected function get_controller($content) {
        return new Head_Controller($content);
    }

    /**
    * Test the returned view of head component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $controller = new Head_Controller($this->initial_content);

        if ($controller->render() !== '') {
            $expectedId = 'changed-head';
            $this->assertStringContainsString($expectedId, $controller->render(), 'View should contain the correct Id');
        }
    }
}
