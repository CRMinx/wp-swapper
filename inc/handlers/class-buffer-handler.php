<?php

namespace WP_Swapper\Handlers;

/**
* Class for opening and closing buffers
*
* @since 0.0.1
*/
class Buffer_Handler {
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
