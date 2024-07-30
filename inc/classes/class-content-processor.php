<?php

namespace WP_Swapper;

use WP_Swapper\Traits\Dom_Handler;
use DOMDocument;

class ContentProcessor {

    use Dom_Handler;

    /**
    * Process the content and handle component changes
    *
    * @param string $content
    * @return string Processed content
    */
    public function process_content($content, $views) {
        $dom = new DOMDocument();
        @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $header = $dom->getElementsByTagName('header')->item(0);
        $this->swap_links($header);

        $footer = $dom->getElementsByTagName('footer')->item(0);
        $this->swap_links($footer);

        $content = $dom->saveHTML();

        $content = $this->create_wrapper($content);

        if (isset($_SERVER['HTTP_HX_REQUEST'])) {
            $content = $this->remove_content_wrapper($content);

            foreach ($views as $view) {
                $content .= $view->render();
            }
        }

        return $content;
    }
}
