<?php

defined( 'ABSPATH' ) || exit;

use WP_Swapper\Components\FooterComponent;
use WP_Swapper\Components\HeaderComponent;
use WP_Swapper\Components\HeadComponent;
use WP_Swapper\Components\BodyComponent;
use WP_Swapper\Components\FooterScriptsComponent;

require WP_SWAPPER_COMPONENTS_PATH . 'class-widget-component.php';
require WP_SWAPPER_CLASSES_PATH . 'class-cache-handler.php';

/**
* Detects search engine bots
*
* @since 0.1
*
* @returns bool true if search engine bot is visiting site, otherwise false.
*/
function swapper_is_bot() {
$bot_agents = [
    'Googlebot',
    'Bingbot',
    'Slurp',
    'DuckDuckBot',
    'Baiduspider',
    'YandexBot',
    'Sogou',
    'Exabot',
    'facebot',
    'ia_archiver',
    'AhrefsBot',
    'MJ12bot',
    'SemrushBot',
    'DotBot',
    'SeznamBot',
    'PiplBot',
    'Mail.RU_Bot',
    'SiteExplorer',
    'Screaming Frog',
    'LinkpadBot',
    'SerpstatBot',
    'MegaIndex',
    'BLEXBot',
    'Uptimebot',
    'TurnitinBot',
    'trendictionbot',
    'VoilaBot',
    'CommonCrawler',
    'Lipperhey',
    'Hatena',
    'MegaIndex',
    'WBSearchBot',
    'ZoominfoBot',
    'SentiBot',
];
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    foreach ( $bot_agents as $bot_agent ) {
        if ( stripos($user_agent, $bot_agent) !== false ) {
            return true;
        }
    }

    return false;
}

/**
* Imports frontend scripts
*
* @since 0.1
*/
function swapper_enqueue_frontend_scripts() {
    wp_enqueue_script(
        'htmx', //Handle for the script
        'https://unpkg.com/htmx.org@2.0.1',
        [],
        '2.0.1',
    );

    wp_enqueue_script(
        'swapper-script',
        WP_SWAPPER_ASSETS_JS_URL . 'swapper-script.js',
        null,
        WP_SWAPPER_VERSION
    );

    wp_enqueue_style(
        'swapper_loader_style',
        WP_SWAPPER_ASSETS_CSS_URL . 'loader.css',
        null,
        WP_SWAPPER_VERSION
    );
}

// Hook the function to wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'swapper_enqueue_frontend_scripts' );

/**
* Adds custom htmx attributes to the body class filter
*
* @since 0.1
*
* @param array $classes Array of body classes.
* @param array $class Additional classes added to the body.
*
* @return array Modified array of body classes.
*/
function swapper_add_htmx_attributes_to_body($classes) {
    if (swapper_is_bot()) {
        return;
    }

    $attributes = array(
        'hx-indicator="#swapper-loader"',
        'hx-target="#swapper-site-content"',
        'hx-swap="innerHTML show:window:top"'
    );

    //$attributes = array(
    //    'hx-boost="true"',
    //);

    echo ' ' . implode(' ', $attributes);
    return $classes;
}

// Hook the function to body_class
add_filter('body_class', 'swapper_add_htmx_attributes_to_body', 20, 2);

/**
* Create a buffer
*
* @since 0.1
*/
function start_output_buffer() {
    if (swapper_is_bot()) {
        return;
    }
    ob_start();
}

/**
* End the buffer and wrap changed content
*
* @since 0.1
*
* @returns string added opening and closing div tags
*/
function end_output_buffer() {
    if (swapper_is_bot()) {
        return;
    }

    $content = ob_get_clean();

    $changedComponents = [];

    $headComponent = new HeadComponent($content);

    // Check if the head content has changed
    if ($headComponent->hasComponentChanged('head', $headComponent->getContent())) {

        // Cache the new head content
        $headComponent->cacheComponent('head', $headComponent->getContent());

        $changedComponents['head'] = $headComponent->getContent();

        // Set a header to indicate that the head content has changed
        header('X-Component-Changed-Head: true');
    }

    $headerComponent = new HeaderComponent($content);

    // Check if the header content has changed
    if ($headerComponent->hasComponentChanged('header', $headerComponent->getContent())) {

        // Cache the new header content
        $headerComponent->cacheComponent('header', $headerComponent->getContent());

        $changedComponents['header'] = $headerComponent->getContent();

        // Set a header to indicate that the header content has changed
        header('X-Component-Changed-Header: true');
    }

    $bodyComponent = new BodyComponent($content);

    // Check if the body attributes have changed
    if ($bodyComponent->hasComponentChanged('body', $bodyComponent->getContent())) {

        // Cache the new body component
        $bodyComponent->cacheComponent('body', $bodyComponent->getContent());

        $changedComponents['body'] = $bodyComponent->getContent();

        // Set a header to indicate that the body content has changed
        header('X-Component-Changed-Body: true');
    }

    $footerComponent = new FooterComponent($content);

    // Check if the footer content has changed
    if ($footerComponent->hasComponentChanged('footer', $footerComponent->getContent())) {

        // Cache the new footer content
        $footerComponent->cacheComponent('footer', $footerComponent->getContent());

        $changedComponents['footer'] = $footerComponent->getContent();

        // Set a header to indicate that the footer content has changed
        header('X-Component-Changed-Footer: true');
    }

    $footerScriptsComponent = new FooterScriptsComponent($content);

    // Check if the footer scripts content has changed
    if ($footerScriptsComponent->hasComponentChanged('footer_scripts', $footerScriptsComponent->getContent())) {

        // Cache the new footer scripts content
        $footerScriptsComponent->cacheComponent('footer_scripts', $footerScriptsComponent->getContent());

        $changedComponents['footer_scripts'] = $footerScriptsComponent->getContent();

        // Set a header to indicate that the footer script content has changed
        header('X-Component-Changed-Footer-Scripts: true');
    }

    /**$widgetComponent = new WidgetComponent();
*
*    $widgetComponent = $widgetComponent->getContent();
*    foreach ($widgetComponent as $sidebarId => $content) {
*        if (CacheHandler::hasComponentChanged("widget_{$sidebarId}", $content)) {
*
*            // Cache the new widget content
*            CacheHandler::cacheComponent("widget_{$sidebarId}", $content);
*
*            // Set a header to indicate that the widget content has changed
*            header("X-Component-Changed-Widget-{$sidebarId}: true");
*        }
*    }
*/

    $dom = new DOMDocument();
    @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $header = $dom->getElementsByTagName('header')->item(0);
    if ($header) {
        $links = $header->getElementsByTagName('a');
        foreach ($links as $link) {
            $link->setAttribute('hx-get', $link->getAttribute('href'));
            $link->setAttribute('hx-push-url', 'true');
        }
    }

    $footer = $dom->getElementsByTagName('footer')->item(0);
    if ($footer) {
        $links = $footer->getElementsByTagName('a');
        foreach ($links as $link) {
            $link->setAttribute('hx-get', $link->getAttribute('href'));
            $link->setAttribute('hx-push-url', 'true');
        }
    }

    $content = $dom->saveHTML();

    $loader = wp_swapper_get_loading_icon();

    //$target_starting_element = get_option('wp_swapper_starting_target_element', '</header>');

    //$escaped_starting_target_element = preg_quote($target_starting_element, '#');

    // Append the opening <div> tag to the end of the header content
    $content = preg_replace(
        '#(</header>)#i',
        '$1<div id="swapper-loader">' . $loader . '<div id="swapper-site-content" hx-boost="true">',
        $content,
        1
    );

    $target_ending_element = get_option('wp_swapper_ending_target_element', '<footer');

    $escaped_ending_target_element = preg_quote($target_ending_element, '#');

    // Prepend the closing </div> tag to the start of the footer content
    $content = preg_replace('#(<footer)#i', '</div></div>$1', $content, 1);

    if (isset($_SERVER['HTTP_HX_REQUEST'])) {
        // Strip content before the swapper-site div
        $content = preg_replace('/.*(<div id="swapper-site-content" hx-boost="true">)/is', '', $content);

        $content = preg_replace('#</div></div><footer.*</footer>.*$#is', '', $content);
    }

    // echo $changedComponents['head'];

    if ($changedComponents['head']) {
        $head = preg_replace('/^<head>|<\/head>$/', '', $changedComponents['head']);

        if ($head) {
            $content = '<div style="display: none;" id="changed-head">' . $head . '</div>' . $content;
        }
    }

    if ($changedComponents['body']) {
        $dom = new DOMDocument();
        @$dom->loadHTML($changedComponents['body'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $body = $dom->getElementsByTagName('body')->item(0);

        if ($body) {
            $attributes = '';
            foreach ($body->attributes as $attribute) {
                $attributes .= $attribute->name . '="' . $attribute->value . '" ';
            }

            $content = '<div style="display: none;" id="changed-body"><div ' . trim($attributes) . '></div></div>' . $content;
        }
    }

    if ($changedComponents['header']) {
        $dom_header = new DOMDocument();
        @$dom_header->loadHTML($changedComponents['header'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $links = $dom_header->getElementsByTagName('a');
        foreach ($links as $link) {
            $link->setAttribute('hx-get', $link->getAttribute('href'));
            $link->setAttribute('hx-push-url', 'true');
        }

        $changedComponents['header'] = $dom_header->saveHTML();
        $content = '<div id="changed-header" style="display: none;">' . $changedComponents['header'] . '</div>' . $content;
    }

    if ($changedComponents['footer']) {
        $dom_footer = new DOMDocument();
        @$dom_footer->loadHTML($changedComponents['footer'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $links = $dom_footer->getElementsByTagName('a');
        foreach ($links as $link) {
            $link->setAttribute('hx-get', $link->getAttribute('href'));
            $link->setAttribute('hx-push-url', 'true');
        }

        $changedComponents['footer'] = $dom_footer->saveHTML();
        $content = $content . '<div id="changed-footer" style="display: none;">' . $changedComponents['footer'] . '</div>';
    }

    if ($changedComponents['footer_scripts']) {
        $content = $content . '<div id="changed-footer-scripts" style="display: none;">' . $changedComponents['footer_scripts'] . '</div>';
    }

    echo $content;
    //echo $changedComponents['footer'];
    //echo $changedComponents['footer_scripts'];
}

// Hook into template_redirect to start output buffering
add_action('template_redirect', 'start_output_buffer');

// Hook into wp_footer to end output buffering and send output
add_action('wp_print_footer_scripts', 'end_output_buffer');

function wp_swapper_get_loading_icon() {
    $icon_option = get_option('wp_swapper_loading_icon', 'spinner');

    if ($icon_option == 'spinner') {
        return '<svg class="htmx-indicator" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="2" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(45 12 12)"><animate attributeName="r" begin="0.125s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(90 12 12)"><animate attributeName="r" begin="0.25s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(135 12 12)"><animate attributeName="r" begin="0.375s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(180 12 12)"><animate attributeName="r" begin="0.5s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(225 12 12)"><animate attributeName="r" begin="0.625s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(270 12 12)"><animate attributeName="r" begin="0.75s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(315 12 12)"><animate attributeName="r" begin="0.875s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>';
    } elseif ($icon_option == 'dots') {
            return '<svg class="htmx-indicator" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#232c34"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#232c34"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>';
    } else {
        return '<div class="htmx-indicator" style="background-image: url(' . esc_url($icon_option) . '); width: 100px; height: 100px;"></div>';
    }
}
