<?php

namespace WP_Swapper\Tests\Controllers;

use WP_Swapper\Tests\TestCase;

/**
* abstract base class for teseting controllers
*
* @since 0.0.1
*/
abstract class Base_Controller_Test extends TestCase {

    /**
    * The Initial content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $initial_content;

    /**
    * The new content
    *
    * @since 0.0.1
    *
    * @var string
    */
    protected $new_content;

    /**
    * The component name
    *
    * @since 0.0.1
    *
    * @var string used in the header
    */
    protected $component_name;

    /**
    * Get the controller to test
    *
    * @since 0.0.1
    *
    * @param string $content
    */
    abstract protected function get_controller($content);

    /**
    * Component should render if it has changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentChanged() {
        $controller = $this->get_controller($this->initial_content);
        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed.');
    }

    /**
    * Component should not render if it doesn't change
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentNotChanged() {
        $controller = $this->get_controller($this->initial_content);
        $controller = $this->get_controller($this->initial_content);

        $this->assertTrue($controller->render() === '', 'Component should not render if no changes.');
    }

    /**
    * Test against cache to see if component changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testCacheComponent() {
        $controller = $this->get_controller($this->initial_content);
        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed.');

        // Update the content
        $controller = $this->get_controller($this->new_content);
        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed.');
    }

    /**
    * If component changes, header should be created
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testCreateHeader() {
        $controller = $this->get_controller($this->initial_content);

        ob_start();
        $controller->render();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains("X-Component-Changed-{$this->component_name}: true", $headers, 'header should be set when component changes.');
    }
}
