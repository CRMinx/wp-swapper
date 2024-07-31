<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Head_Controller;

class Head_Controller_Test extends TestCase {

    private $initial_content = '<html><head><link /></head><body></body></html>';

    /**
    * Component should render if it has changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentChanged() {
        $controller = new Head_Controller($this->initial_content);

        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed');
    }

    /**
    * Component should not render if it doesn't change
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentNotChanged() {
        $controller = new Head_Controller($this->initial_content);
        $controller = new Head_Controller($this->initial_content);

        $this->assertTrue($controller->render() === '', 'Component should not render if no changes');
    }

    /**
    * Test against cache to see if component changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testCacheComponent() {
        $controller = new Head_Controller($this->initial_content);

        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed');

        // Update the content
        $newContent = '<html><head><link /><script></script></head><body></body></html>';
        $controller = new Head_Controller($newContent);
        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed');
    }

    /**
    * If component changes, header should be created
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testCreateHeader() {
        $controller = new Head_Controller($this->initial_content);

        ob_start();
        $controller->render();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('X-Component-Changed-Head: true', $headers, 'header should be set when component changes.');
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
