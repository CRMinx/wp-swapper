<?php
/**
* Loading Icon section for selecting a loading icon
*
* @since 0.1
*/

?>

<div class="w-full text-brand-primary p-6">
    <div class="flex items-center space-x-6">
        <svg class="size-12 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="2" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(45 12 12)"><animate attributeName="r" begin="0.125s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(90 12 12)"><animate attributeName="r" begin="0.25s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(135 12 12)"><animate attributeName="r" begin="0.375s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(180 12 12)"><animate attributeName="r" begin="0.5s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(225 12 12)"><animate attributeName="r" begin="0.625s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(270 12 12)"><animate attributeName="r" begin="0.75s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(315 12 12)"><animate attributeName="r" begin="0.875s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
        <h2 class="text-3xl font-extrabold">Edit Loading Icon</h2>
    </div>
    <hr class="mt-6" />
    <div class="mt-12">
        <p class="text-xl font-bold">Preset Loaders</p>
        <hr class="mt-2" />
        <form class="mt-2" method="post" action="options.php">
            <?php
            settings_fields('wp_swapper_options_group');
            do_settings_sections('wp_swapper_options_group');
            ?>
            <div class="flex items-center space-x-6">
                <input id="spinner" type="radio" name="wp_swapper_loading_icon" value="spinner" <?php checked('spinner', get_option('wp_swapper_loading_icon')); ?> />
                <div class="flex flex-col items-center">
                    <label class="text-lg" for="spinner">Spinner</label>
                    <svg class="size-12 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="2" r="0" fill="currentColor"><animate attributeName="r" begin="0" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(45 12 12)"><animate attributeName="r" begin="0.125s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(90 12 12)"><animate attributeName="r" begin="0.25s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(135 12 12)"><animate attributeName="r" begin="0.375s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(180 12 12)"><animate attributeName="r" begin="0.5s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(225 12 12)"><animate attributeName="r" begin="0.625s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(270 12 12)"><animate attributeName="r" begin="0.75s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="2" r="0" fill="#232c34" transform="rotate(315 12 12)"><animate attributeName="r" begin="0.875s" calcMode="spline" dur="1s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                </div>
            </div>
            <div class="flex items-center space-x-6 mt-6">
                <input type="radio" name="wp_swapper_loading_icon" value="dots" <?php checked('dots', get_option('wp_swapper_loading_icon')); ?> />
                <div class="flex flex-col items-center">
                    <label class="text-lg" for="dots">Dots</label>
                    <svg class="size-12 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="18" cy="12" r="0" fill="currentColor"><animate attributeName="r" begin=".67" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="12" cy="12" r="0" fill="#232c34"><animate attributeName="r" begin=".33" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle><circle cx="6" cy="12" r="0" fill="#232c34"><animate attributeName="r" begin="0" calcMode="spline" dur="1.5s" keySplines="0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8;0.2 0.2 0.4 0.8" repeatCount="indefinite" values="0;2;0;0"/></circle></svg>
                </div>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <div class="mt-12">
        <p class="text-xl font-bold">Custom Loader</p>
        <hr class="mt-2" />
        <form class="mt-2" method="post" action="options.php">
            <?php
            settings_fields('wp_swapper_options_group');
            do_settings_sections('wp_swapper_options_group');
            ?>
            <input type="hidden" id="wp_swapper_custom_icon" name="wp_swapper_loading_icon" value="<?php echo esc_attr(get_option('wp_swapper_loading_icon')); ?>" />
            <button type="button" class="button" id="wp_swapper_select_icon_button">Select Custom Icon</button>
            <div id="wp_swapper_custom_icon_preview" style="margin-top:10px;">
                <?php if ($icon = get_option('wp_swapper_loading_icon')) : ?>
                    <img src="<?php echo esc_url($icon); ?>" style="max-width:100px;" />
                <?php endif; ?>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
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
