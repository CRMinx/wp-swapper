<?php

namespace WP_Swapper\Tests\Handlers;

use Brain\Monkey\Functions;
use WP_Swapper\Handlers\Enqueue_Handler;
use WP_Swapper\Tests\TestCase;

/**
* Test Enqueue Scripts
*
* @since 0.0.1
*/
class Enqueue_Handler_Test extends TestCase
{
    /**
    * Ensure scripts are enqueued
    *
    * @since 0.0.1
    */
    public function testEnqueueScriptsAndStyles()
    {
        $enqueue_handler = new Enqueue_Handler();
        $this->assertNotFalse(has_action('wp_enqueue_scripts', [$enqueue_handler, 'register_styles']));
        $this->assertNotFalse(has_action('wp_enqueue_scripts', [$enqueue_handler, 'register_scripts']));
    }

    /**
    * Ensure correct styles are registered.
    *
    * @since 0.0.1
    */
    public function testRegisterStyles()
    {
        Functions\expect('wp_register_style')
            ->once()
            ->with(
                'swapper_loader_style',
                'localhost/assets/css/loader.css',
                null,
                '0.0.1'
            );
        Functions\expect('wp_enqueue_style')
            ->once()
            ->with('swapper_loader_style');

        $enqueue_handler = new Enqueue_Handler();
        $enqueue_handler->register_styles();
    }

    /**
    * Ensure correct scripts are registered.
    *
    * @since 0.0.1
    */
    public function testRegisterScripts()
    {
        Functions\expect('wp_register_script')
            ->once()
            ->with(
                'htmx',
                'https://unpkg.com/htmx.org@2.0.1',
                [],
                '2.0.1'
            );
        Functions\expect('wp_register_script')
            ->once()
            ->with(
                'swapper_script',
                'localhost/assets/js/swapper-script.js',
                ['htmx'],
                '0.0.1'
            );
        Functions\expect('wp_enqueue_script')
            ->once()
            ->with('htmx');
        Functions\expect('wp_enqueue_script')
            ->once()
            ->with('swapper_script');

        $enqueue_handler = new Enqueue_Handler();
        $enqueue_handler->register_scripts();
    }
}
