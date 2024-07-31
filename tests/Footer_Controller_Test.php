<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Footer_Controller;

class Footer_Controller_Test extends TestCase {

    private $initial_content = '<footer>Initial Content</footer>';

    /**
    * Component should render if it has changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentChanged() {
        $controller = new Footer_Controller($this->initial_content);

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
        $controller = new Footer_Controller($this->initial_content);
        $controller = new Footer_Controller($this->initial_content);

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
        $controller = new Footer_Controller($this->initial_content);

        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed');

        // Update the content
        $newContent = '<footer class="new-class">UpdatedContent</footer>';
        $controller = new Footer_Controller($newContent);
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
        $controller = new Footer_Controller($this->initial_content);

        ob_start();
        $controller->render();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('X-Component-Changed-Footer: true', $headers, 'Header should be set when component changes.');
    }

    /**
    * Test the returned view of footer component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $content = '<footer class="test-class">Initial Content</footer>';
        $controller = new Footer_Controller($content);

        if ($controller->render() !== '') {
            $expectedId = 'changed-footer';
            $this->assertStringContainsString($expectedId, $controller->render(), 'View should contain the correct Id');
        }
    }
}
