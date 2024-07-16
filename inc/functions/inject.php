<?php

defined( 'ABSPATH' ) || exit;

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
* Imports htmx into the footer
*
* @since 0.1
*/
function swapper_import_htmx_into_footer() {
    wp_enqueue_script(
        'htmx', //Handle for the script
        'https://unpkg.com/htmx.org@2.0.1',
        [],
        '2.0.1',
        true
    );
}

// Hook the funciton to wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'swapper_import_htmx_into_footer' );

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
        'hx-indicator="#swapper-content"',
        'hx-target="#swapper-site-content"',
        'hx-swap="innerHTML show:window:top"'
    );

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

    $content = $dom->saveHTML();
    // Append the opening <div> tag to the end of the header content
    $content = preg_replace('/(<\/header>)/i', '</header><div id="swapper-site-content" hx-boost="true">', $content, 1);

    // Prepend the closing </div> tag to the start of the footer content
    $content = preg_replace('/(<footer)/i', '</div><footer', $content, 1);

    if (isset($_SERVER['HTTP_HX_REQUEST'])) {
        // Strip content before the swapper-site div
        $content = preg_replace('/.*(<div id="swapper-site-content" hx-boost="true">)/is', '$1', $content);
        // Strip content after the closing footer tag
        $content = preg_replace('/<footer.*$/is', '', $content);
    }

    echo $content;
}

// Hook into template_redirect to start output buffering
add_action('template_redirect', 'start_output_buffer');

// Hook into wp_footer to end output buffering and send output
add_action('wp_footer', 'end_output_buffer');
