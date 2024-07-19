<?php
/**
* Advanced settings for target swapping area.
*
* @since 0.1
*/

?>

<div class="w-full text-brand-primary p-6">
    <div class="flex items-center space-x-6">
        <svg class="size-12 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m9.25 22l-.4-3.2q-.325-.125-.612-.3t-.563-.375L4.7 19.375l-2.75-4.75l2.575-1.95Q4.5 12.5 4.5 12.338v-.675q0-.163.025-.338L1.95 9.375l2.75-4.75l2.975 1.25q.275-.2.575-.375t.6-.3l.4-3.2h5.5l.4 3.2q.325.125.613.3t.562.375l2.975-1.25l2.75 4.75l-2.575 1.95q.025.175.025.338v.674q0 .163-.05.338l2.575 1.95l-2.75 4.75l-2.95-1.25q-.275.2-.575.375t-.6.3l-.4 3.2zm2.8-6.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5"/></svg>
        <h2 class="text-3xl font-extrabold">Advanced Settings</h2>
    </div>
    <hr class="mt-6" />
    <div class="mt-12">
        <p class="text-xl font-bold">Target Elements</p>
        <p>Select the elements to create a container for content swapping.</p>
        <hr class="mt-2" />
        <form class="mt-2" method="post" action="options.php">
            <?php
            settings_fields('wp_swapper_target_elements_group');
            do_settings_sections('wp_swapper_target_elements_group');
            ?>
            <div class="flex flex-col">
                <label class="text-lg" for="starting-target-element">Starting Target Element</label>
                <p>Default: &#8249;&#8260;header&#8250;</p>
                <input id="starting-target-element" type="text" name="wp_swapper_starting_target_element" value="<?php echo esc_attr(get_option('wp_swapper_starting_target_element')) ?>" />
                <label class="text-lg" for="starting-target-element-index">Starting Target Element Index</label>
                <p>If multiple elements return, which one?</p>
                <p>Default: 0 (First appearance of the specified tag.)</p>
                <input id="starting-target-element-index" type="number" name="wp_swapper_starting_target_element_index" value="<?php echo esc_attr(get_option('wp_swapper_starting_target_element_index')) ?>" />
            </div>
            <div class="flex flex-col">
                <label class="text-lg" for="starting-target-element">Ending Target Element</label>
                <p>Default: &#8249;footer</p>
                <input id="starting-target-element" type="text" name="wp_swapper_ending_target_element" value="<?php echo esc_attr(get_option('wp_swapper_ending_target_element')) ?>" />
                <label class="text-lg" for="ending-target-element-index">Ending Target Element Index</label>
                <p>If multiple elements return, which one?</p>
                <p>Default: -1 (Last appearance of the specified tag.)</p>
                <input id="ending-target-element-index" type="number" name="wp_swapper_ending_target_element_index" value="<?php echo esc_attr(get_option('wp_swapper_ending_target_element_index')) ?>" />
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
</div>
