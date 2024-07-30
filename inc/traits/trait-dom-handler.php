<?php

namespace WP_Swapper\Traits;

/**
* Trait for interacting with DOM Elements
*
* @since 0.0.1
*/
trait Dom_Handler {

    /**
    * Add hx-get to links
    *
    * @param $element the element that contains a elements
    *
    * @return void
    */
    public function swap_links($element) {
        if ($element) {
            $links = $element->getElementsByTagName('a');
            foreach ($links as $link) {
                $link->setAttribute('hx-get', $link->getAttribute('href'));
                $link->setAttribute('hx-push-url', 'true');
            }
        }
    }

    /**
     * Create wrapper
     *
     * @param $content
     *
     * @return string
     */
    private function create_wrapper($content) {
        $loader = wp_swapper_get_loading_icon();

        $content = preg_replace(
            '#(</header>)#i',
            '$1<div id="swapper-loader">' . $loader . '<div id="swapper-site-content" hx-boost="true">',
            $content,
            1
        );

        $content = preg_replace('#(<footer)#i', '</div></div>$1', $content, 1);

        return $content;
    }

    /**
     * Remove header and footer from around content
     *
     * @param $content
     *
     * @return string
     */
    private function remove_content_wrapper($content) {
        $content = preg_replace('/.*(<div id="swapper-site-content" hx-boost="true">)/is', '', $content);

        $content = preg_replace('#</div></div><footer.*</footer>.*$#is', '', $content);

        return $content;
    }
}
