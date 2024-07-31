<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Scripts_Controller;

/**
* Class for testing the Scripts Controller
*
* @since 0.0.1
*/
class Scripts_Controller_Test extends Base_Controller_Test {
    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content = '<body><script src="example"></script></body>';

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content = '<body><script src="new-example"></script></body>';

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the scripts
    */
    protected $component_name = 'Scripts';

    /**
    * Provide the Scripts_Controller class for testing
    *
    * @since 0.0.1
    *
    * @param string $content
    *
    * @return Scripts_Controller
    */
    protected function get_controller($content) {
        return new Scripts_Controller($content);
    }
    /**
    * Test the returned view of scripts component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $controller = new Scripts_Controller($this->initial_content);

        if ($controller->render() !== '') {
            $expectedId = 'id="changed-footer-scripts"';
            $this->assertStringContainsString($expectedId, $controller->render(), 'View should contain the correct Id');
        }
    }
}
