<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Controllers\Body_Controller;

class Body_Controller_Test extends TestCase {

    private $initial_content = '<body>Initial Content</body>';

    /**
    * Component should render if it has changed
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testComponentChanged() {
        $controller = new Body_Controller($this->initial_content);

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
        $controller = new Body_Controller($this->initial_content);
        $controller = new Body_Controller($this->initial_content);

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
        $controller = new Body_Controller($this->initial_content);

        $this->assertTrue($controller->render() !== '', 'Component should render if it has changed');

        // Update the content
        $newContent = '<body class="new-class">UpdatedContent</body>';
        $controller = new Body_Controller($newContent);
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
        $controller = new Body_Controller($this->initial_content);

        ob_start();
        $controller->render();
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('X-Component-Changed-Body: true', $headers, 'Header should be set when component changes.');
    }

    /**
    * Test the returned view of body component
    *
    * @since 0.0.1
    *
    * @runInSeparateProcess
    */
    public function testView() {
        $content = '<body class="test-class">Initial Content</body>';
        $controller = new Body_Controller($content);

        if ($controller->render() !== '') {
            $expectedView = '<div style="display: none;" id="changed-body"><div class="test-class"></div></div>';
            $this->assertStringContainsString($expectedView, $controller->render(), 'View should contain the correct HTML');
        }
    }
}
