<?php

namespace WP_Swapper;

use WP_Swapper\Controllers\Head_Controller;
use WP_Swapper\Controllers\Header_Controller;
use WP_Swapper\Controllers\Body_Controller;
use WP_Swapper\Controllers\Footer_Controller;
use WP_Swapper\Controllers\Scripts_Controller;
use WP_Swapper\Handlers\Buffer_Handler;
use WP_Swapper\Traits\Bot_Handler;
use WP_Swapper\Content_Processor;

class Component_Router {

    use Bot_Handler;

    /**
     * The buffer handler class
     *
     * @since 0.0.1
     *
     * @var Buffer_Handler
     */
    private $buffer_handler;

    /**
     * The Content Processor class
     *
     * @since 0.0.1
     *
     * @var Content_Processor
     */
    private $content_processor;

    /**
     * Constructor method
     * If user is not a search engine bot
     * Create the buffer and process the
     * content.
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function __construct() {
        $this->buffer_handler = new Buffer_Handler();
        $this->content_processor = new Content_Processor();
        if (!$this->is_bot()) {
            add_action('template_redirect', [$this, 'start_buffer']);
            add_action('wp_print_footer_scripts', [$this, 'process_content']);
        }
    }

    /**
     * Start the buffer
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function start_buffer() {
        $this->buffer_handler->start_output_buffer();
    }

    /**
     * End the buffer
     *
     * @since 0.0.1
     *
     * @return void
     */
    private function end_buffer() {
        return $this->buffer_handler->end_output_buffer();
    }

    /**
     * Process the buffer.
     * Echo the results to end user.
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function process_content() {
        $content = $this->end_buffer();
        $controllers = $this->controllers($content);
        echo $this->content_processor->process_content($content, $this->views($controllers));
    }

    /**
     * Create an array of views
     *
     * @since 0.0.1
     *
     * @param array $controllers array of controller objects
     *
     * @return array of views
     */
    private function views($controllers) {
        $views = [];

        foreach ($controllers as $controller) {
            $views[] = $controller->render();
        }

        return $views;
    }

    /**
     * Create an array of controllers.
     *
     * @since 0.0.1
     *
     * @param $content buffer page
     *
     * @return array of controllers.
     */
    private function controllers($content) {
        $head = new Head_Controller($content);
        $header = new Header_Controller($content);
        $body = new Body_Controller($content);
        $footer = new Footer_Controller($content);
        $Scripts = new Scripts_Controller($content);
        return [
            $head,
            $header,
            $body,
            $footer,
            $Scripts,
        ];
    }
}
