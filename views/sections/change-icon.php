<div>
    <h2 class="font-extrabold text-3xl">Settings</h2>
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
    <form method="get" action="">
        <button>Check for updates</button>
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
