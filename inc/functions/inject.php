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
        'hx-indicator="#swapper-loader"',
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

    $footer = $dom->getElementsByTagName('footer')->item(0);
    if ($footer) {
        $links = $footer->getElementsByTagName('a');
        foreach ($links as $link) {
            $link->setAttribute('hx-get', $link->getAttribute('href'));
            $link->setAttribute('hx-push-url', 'true');
        }
    }

    $content = $dom->saveHTML();

    $loader = wp_swapper_add_loading_icon();
    // Append the opening <div> tag to the end of the header content
    $content = preg_replace('/(<\/header>)/i', '</header><div id="swapper-loader">' . $loader . '<div id="swapper-site-content" hx-boost="true">', $content, 1);

    // Prepend the closing </div> tag to the start of the footer content
    $content = preg_replace('/(<footer)/i', '</div></div><footer', $content, 1);

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

function wp_swapper_add_loading_icon() {
    $icon_option = get_option('wp_swapper_loading_icon');
    $custom_icon = get_option('wp_swapper_custom_icon');

    if ($icon_option == 'spinner') {
        return '<div class="wp-swapper-spinner"></div>';
    } elseif ($icon_option == 'dots') {
        return '<div class="dots"></div>';
    } elseif ($icon_option == 'custom' && $custom_icon) {
        return '<div class="wp-swapper-custom-loader" style="background-image: url(' . esc_url($custom_icon) . ');"></div>';
    }
}

function wp_swapper_add_admin_menu() {
    add_menu_page(
        'WP Swapper Settings',
        'WP Swapper',
        'manage_options',
        'wp_swapper',
        'wp_swapper_settings_page'
    );
}
add_action('admin_menu', 'wp_swapper_add_admin_menu');

function wp_swapper_register_settings() {
    register_setting('wp_swapper_options_group', 'wp_swapper_loading_icon');
}
add_action('admin_init', 'wp_swapper_register_settings');

function wp_swapper_enqueue_media() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'wp_swapper_enqueue_media');

function wp_swapper_settings_page() {
?>
<div class="wrap">
    <h1>WP Swapper Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('wp_swapper_options_group');
        do_settings_sections('wp_swapper_options_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Loading Icon</th>
                <td>
                    <input type="radio" name="wp_swapper_loading_icon" value="spinner" <?php checked('spinner', get_option('wp_swapper_loading_icon')); ?> /> Spinner<br />
                    <input type="radio" name="wp_swapper_loading_icon" value="dots" <?php checked('dots', get_option('wp_swapper_loading_icon')); ?> /> Dots<br />
                    <input type="radio" name="wp_swapper_loading_icon" value="custom" <?php checked('custom', get_option('wp_swapper_loading_icon')); ?> /> Custom<br />
                    <input type="hidden" id="wp_swapper_custom_icon" name="wp_swapper_custom_icon" value="<?php echo esc_attr(get_option('wp_swapper_custom_icon')); ?>" />
                    <button type="button" class="button" id="wp_swapper_select_icon_button">Select Custom Icon</button>
                    <div id="wp_swapper_custom_icon_preview" style="margin-top:10px;">
                        <?php if ($icon = get_option('wp_swapper_custom_icon')) : ?>
                            <img src="<?php echo esc_url($icon); ?>" style="max-width:100px;" />
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<script>
    jQuery(document).ready(function($){
        var customIconButton = $('#wp_swapper_select_icon_button');
        customIconButton.on('click', function(e) {
            e.preventDefault();
            var customIcon = wp.media({
                title: 'Select Custom Icon',
                button: {
                    text: 'Use this icon'
                },
                multiple: false
            }).open()
            .on('select', function() {
                var attachment = customIcon.state().get('selection').first().toJSON();
                $('#wp_swapper_custom_icon').val(attachment.url);
                $('#wp_swapper_custom_icon_preview').html('<img src="' + attachment.url + '" style="max-width:100px;" />');
            });
        });
    });
</script>
<?php
}

function wp_swapper_enqueue_loading_icon() {
    $icon_option = get_option('wp_swapper_loading_icon');
    $custom_icon = get_option('wp_swapper_custom_icon');

    if ($icon_option == 'spinner') {
        wp_enqueue_style('wp-swapper-spinner', plugin_dir_url(__FILE__) . 'icons/spinner.css');
    } elseif ($icon_option == 'dots') {
        wp_enqueue_style('wp-swapper-dots', plugin_dir_url(__FILE__) . 'icons/dots.css');
    } elseif ($icon_option == 'custom' && $custom_icon) {
        wp_enqueue_style('wp-swapper-custom', $custom_icon);
    }
}
add_action('wp_enqueue_scripts', 'wp_swapper_enqueue_loading_icon');
