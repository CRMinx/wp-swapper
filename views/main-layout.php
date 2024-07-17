<?php
/**
* Main admin layout
*
* @since 0.1
*/

?>
<div x-data="{ selectedSection: 'loading-icon' }" class="flex w-full">

    <div class="w-1/4">

        <div class="p-4">
            <div class="flex items-center space-x-2 text-brand-primary">
                <div class="size-10">
                    <img src="<?php echo WP_SWAPPER_ASSETS_IMG_URL . 'wp-swapper-logo.png'?>" />
                </div>
                <h1 class="font-extrabold text-2xl">WP Swapper</h1>
            </div>
            <p class="text-brand-secondary">The official content swapping plugin!</p>
        </div>

        <div class="w-full">

            <div class="cursor-pointer p-4 border-brand-primary hover:border-l" @click="selectedSection = 'dashboard'" :class="{ 'active': selectedSection === 'dashboard' }">
                <p class="font-bold text-xl">Dashboard</p>
                <p class="text-brand-secondary">Account Info</p>
            </div>

            <div class="p-4 cursor-pointer border-brand-primary hover:border-l" @click="selectedSection = 'loading-icon'" :class="{ 'active': selectedSection === 'loading-icon' }">
                <p class="font-bold text-xl">Loading Icon</p>
                <p class="text-brand-secondary">Change your loading icon</p>
            </div>

            <div class="p-4 cursor-pointer border-brand-primary hover:border-l" @click="selectedSection = 'advanced'" :class="{ 'active': selectedSection === 'advanced' }">
                <p class="font-bold text-xl">Advanced</p>
                <p class="text-brand-secondary">Fit your exact needs</p>
            </div>

            <div class="p-4 cursor-pointer border-brand-primary hover:border-l" @click="selectedSection = 'help'" :class="{ 'active': selectedSection === 'help' }">
                <p class="font-bold text-xl">Help</p>
                <p class="text-brand-secondary">Links to various resources</p>
            </div>

        </div>

    </div>

    <div class="w-3/4 bg-white">

        <div x-show="selectedSection === 'dashboard'" class="section w-full">
            <?php include WP_SWAPPER_VIEWS_PATH . 'sections/dashboard.php'; ?>
        </div>

        <div x-show="selectedSection === 'loading-icon'" class="section w-full" style="display: none;">
            <?php include WP_SWAPPER_VIEWS_PATH . 'sections/change-icon.php'; ?>
        </div>

        <div x-show="selectedSection === 'advanced'" class="section w-full" style="display: none;">
            <?php include WP_SWAPPER_VIEWS_PATH . 'sections/advanced.php'; ?>
        </div>

        <div x-show="selectedSection === 'help'" class="section w-full" style="display: none;">
            <?php include WP_SWAPPER_VIEWS_PATH . 'sections/help.php'; ?>
        </div>

    </div>


</div>
