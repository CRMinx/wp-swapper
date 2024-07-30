<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Handlers\Buffer_Handler;

/**
* Tests for Buffer Handler class
*
* @since 0.0.1
*/
class Buffer_Handler_Test extends TestCase
{
    /**
     * Testing for buffer to start
     *
     * @since 0.0.1
     */
    public function testStartOutputBuffer()
    {
        $bufferHandler = new Buffer_Handler();

        $bufferHandler->start_output_buffer();

        echo 'test content';

        $this->assertTrue(ob_get_length() > 0);

        ob_end_clean();
    }

    /**
    * Testing for buffer to end
    *
    * @since 0.0.1
    */
    public function testEndOutputBuffer()
    {
        $bufferHandler = new Buffer_Handler();

        ob_start();

        echo 'test content';

        $bufferHandler->end_output_buffer();

        $this->assertTrue(ob_get_length() === 0);
    }
}
