<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Body_Controller;

/**
* Class for testing the Body Controller
*
* @since 0.0.1
*/
class Body_Controller_Test extends Base_Controller_Test {
    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content = '<body class="intitial-class">Initial Content</body>';

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content = '<body class="updated-class">Updated Content</body>';

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the header
    */
    protected $component_name = 'Body';

    /**
    * Provide the Body_Controller class for testing
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return Body_Controller
    */
    protected function get_controller($content) {
        return new Body_Controller($content);
    }

    /**
    * Test the returned view of body component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $controller = new Body_Controller($this->initial_content);

        if ($controller->render() !== '') {
            $expectedView = 'id="changed-body"';
            $this->assertStringContainsString($expectedView, $controller->render(), 'View should contain the correct HTML');
        }
    }
}
