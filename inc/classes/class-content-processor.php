<?php

namespace WP_Swapper;

use DOMDocument;
use WP_Swapper\Components\HeadComponent;
use WP_Swapper\Components\HeaderComponent;
use WP_Swapper\Components\BodyComponent;
use WP_Swapper\Components\FooterComponent;
use WP_Swapper\Components\FooterScriptsComponent;

class ContentProcessor {
    /**
     * Create an array of components.
     *
     * @param $content buffer page
     *
     * @return array of components.
     */
    private function get_components($content) {
        $headComponent = new HeadComponent($content);
        $headerComponent = new HeaderComponent($content);
        $bodyComponent = new BodyComponent($content);
        $footerComponent = new FooterComponent($content);
        $footerScriptsComponent = new FooterScriptsComponent($content);
        return [
            $headComponent,
            $headerComponent,
            $bodyComponent,
            $footerComponent,
            $footerScriptsComponent,
        ];
    }

    /**
     * Create an array of changed components.
     *
     * @param array $components Component objects
     *
     * @return array of changed component objects
     */
    private function check_if_components_changed($components) {
        $changedComponents = [];
        foreach ($components as $component) {
            $componentName = (new \ReflectionClass($component))->getShortName();
            if ($component->hasComponentChanged($componentName, $component->getContent())) {
                $component->cacheComponent($componentName, $component->getContent());
                $changedComponents[$componentName] = $component->getContent();
                header('X-Component-Changed-' . $componentName . ': true');
            }
        }
        return $changedComponents;
    }

    /**
    * Process the content and handle component changes
    *
    * @param string $content
    * @return string Processed content
    */
    public function process_content($content) {
        $components = $this->get_components($content);
        $changedComponents = $this->check_if_components_changed($components);


        $dom = new DOMDocument();
        @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $header = $dom->getElementsByTagName('header')->item(0);
        $this->swap_links($header);

        $footer = $dom->getElementsByTagName('footer')->item(0);
        $this->swap_links($footer);


        $content = $dom->saveHTML();

        $loader = wp_swapper_get_loading_icon();

        $content = preg_replace(
            '#(</header>)#i',
            '$1<div id="swapper-loader">' . $loader . '<div id="swapper-site-content" hx-boost="true">',
            $content,
            1
        );

        $content = preg_replace('#(<footer)#i', '</div></div>$1', $content, 1);

        if (isset($_SERVER['HTTP_HX_REQUEST'])) {
            $content = preg_replace('/.*(<div id="swapper-site-content" hx-boost="true">)/is', '', $content);

            $content = preg_replace('#</div></div><footer.*</footer>.*$#is', '', $content);
        }

        if ($changedComponents['HeadComponent']) {
            $head = preg_replace('/^<head>|<\/head>$/', '', $changedComponents['HeadComponent']);

            if ($head) {
                $content = '<div style="display: none;" id="changed-head">' . $head . '</div>' . $content;
            }
        }

        if ($changedComponents['BodyComponent']) {
            $dom = new DOMDocument();
            @$dom->loadHTML($changedComponents['BodyComponent'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $body = $dom->getElementsByTagName('body')->item(0);

            if ($body) {
                $attributes = '';
                foreach ($body->attributes as $attribute) {
                    $attributes .= $attribute->name . '="' . $attribute->value . '" ';
                }

                $content = '<div style="display: none;" id="changed-body"><div ' . trim($attributes) . '></div></div>' . $content;
            }
        }

        if ($changedComponents['HeaderComponent']) {
            $dom_header = new DOMDocument();
            @$dom_header->loadHTML($changedComponents['HeaderComponent'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $this->swap_links($dom_header);

            $changedComponents['HeaderComponent'] = $dom_header->saveHTML();
            $content = '<div id="changed-header" style="display: none;">' . $changedComponents['HeaderComponent'] . '</div>' . $content;
        }

        if ($changedComponents['FooterComponent']) {
            $dom_footer = new DOMDocument();
            @$dom_footer->loadHTML($changedComponents['FooterComponent'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $this->swap_links($dom_footer);

            $changedComponents['FooterComponent'] = $dom_footer->saveHTML();
            $content = $content . '<div id="changed-footer" style="display: none;">' . $changedComponents['FooterComponent'] . '</div>';
        }

        if ($changedComponents['FooterScriptsComponent']) {
            $content = $content . '<div id="changed-footer-scripts" style="display: none;">' . $changedComponents['FooterScriptsComponent'] . '</div>';
        }

        return $content;
    }

    private function swap_links($element) {
        if ($element) {
            $links = $element->getElementsByTagName('a');
            foreach ($links as $link) {
                $link->setAttribute('hx-get', $link->getAttribute('href'));
                $link->setAttribute('hx-push-url', 'true');
            }
        }
    }
}
