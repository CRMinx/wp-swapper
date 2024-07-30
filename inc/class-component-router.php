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

    private $buffer_handler;

    private $content_processor;

    public function __construct() {
        $this->buffer_handler = new Buffer_Handler();
        $this->content_processor = new Content_Processor();
        if (!$this->is_bot()) {
            add_action('template_redirect', [$this, 'start_buffer']);
            add_action('wp_print_footer_scripts', [$this, 'process_content']);
        }
    }

    public function start_buffer() {
        $this->buffer_handler->start_output_buffer();
    }

    private function end_buffer() {
        return $this->buffer_handler->end_output_buffer();
    }

    public function process_content() {
        $content = $this->end_buffer();
        echo $this->content_processor->process_content($content, $this->controllers($content));
    }

    /**
     * Create an array of components.
     *
     * @param $content buffer page
     *
     * @return array of components.
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
