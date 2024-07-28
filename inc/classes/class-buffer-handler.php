<?php

namespace WP_Swapper;

class BufferHandler {
    /**
    * Bot detector instance
    *
    * @var BotDetector
    */
    private $bot_detector;

    /**
    * Constructor
    *
    * @param BotDetector $bot_detector detects search engine bots
    */
    public function __construct(BotDetector $bot_detector) {
        $this->bot_detector = $bot_detector;
        if (!$this->bot_detector->is_bot()) {
            add_action('template_redirect', [$this, 'start_output_buffer']);
            //add_action('wp_print_footer_scripts', [$this, 'end_output_buffer']);
        }
    }

    /**
    * Start the output buffer
    *
    * @since 0.0.1
    */
    public function start_output_buffer() {
        ob_start();
    }

    /**
    * End the buffer and return content
    *
    * @since 0.0.1
    *
    * @return string the buffer
    */
    public function end_output_buffer() {
        return ob_get_clean();
    }
}
