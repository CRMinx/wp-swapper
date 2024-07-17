<?php
/**
* Dashboard section to display links and account status
*
* @since 0.1
*/

?>

<div class="w-full bg-white text-brand-primary p-6">
    <div class="flex items-center space-x-6">
        <svg class="size-12 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"><path fill="currentColor" d="m222.14 105.85l-80-80a20 20 0 0 0-28.28 0l-80 80A19.86 19.86 0 0 0 28 120v96a12 12 0 0 0 12 12h64a12 12 0 0 0 12-12v-52h24v52a12 12 0 0 0 12 12h64a12 12 0 0 0 12-12v-96a19.86 19.86 0 0 0-5.86-14.15M204 204h-40v-52a12 12 0 0 0-12-12h-48a12 12 0 0 0-12 12v52H52v-82.35l76-76l76 76Z"/></svg>
        <h2 class="text-3xl font-extrabold">Dashboard</h2>
    </div>
    <hr class="mt-6" />
    <div class="mt-12">
        <div class="flex justify-between w-full items-center">
            <p class="text-xl font-bold">My Account</p>
            <button class="flex items-center space-x-2">
                <svg class="text-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M20.5 5.835A10.49 10.49 0 0 0 12 1.5c-5.427 0-9.89 4.115-10.443 9.396l-.104.994l1.99.209l.103-.995A8.501 8.501 0 0 1 19.213 7.5H15.5v2h7v-7h-2zm.057 6.066l-.104.995A8.501 8.501 0 0 1 4.787 16.5H8.5v-2h-7v7h2v-3.335A10.49 10.49 0 0 0 12 22.5c5.426 0 9.89-4.115 10.442-9.396l.104-.994z"/></svg>
                <p class="text-lg">Refresh info</p>
            </button>
        </div>
        <hr class="mt-2" />
        <div class="flex justify-between items-start mt-2">
            <div class="flex flex-col space-y-2">
                <div class="flex items-center space-x-4">
                    <p class="text-lg">License: </p>
                    <div class="flex items-center text-green-600">
                        <svg class="text-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a1 1 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a1 1 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a1 1 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a1 1 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a1 1 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a1 1 0 0 1-.696-.288l-.893-.893A2.98 2.98 0 0 0 12 2m3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253l-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/></svg>
                        <p class="text-lg">Infinite</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <p class="text-lg">Expiration Date: </p>
                    <div class="flex items-center text-green-600">
                        <svg class="text-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a1 1 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a1 1 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a1 1 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a1 1 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a1 1 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a1 1 0 0 1-.696-.288l-.893-.893A2.98 2.98 0 0 0 12 2m3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253l-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/></svg>
                        <p class="text-lg">January 17, 2025</p>
                    </div>
                </div>
            </div>
            <button class="bg-brand-primary text-white font-bold text-lg px-4 py-1 rounded-lg">My Account</button>
        </div>
    </div>

    <div class="mt-12">
        <p class="text-xl font-bold">Frequently Asked Questions</p>
        <hr class="mt-2" />
        <div class="mt-2 bg-brand-background rounded-lg text-lg p-2">
            <ul class="text-blue-500 underline">
                <li><a href="#">My Site Is Broken</a></li>
                <li><a href="#">My header isn't changing</a></li>
                <li><a href="#">The wrong content is swapping</a></li>
            </ul>
            <hr class="mt-2" />
            <div class="flex justify-between items-start mt-2">
                <div>
                    <p class="font-semibold text-lg">Still can't find a solution?</p>
                    <p class="text-brand-secondary text-lg">Submit a ticket and get help from our professional support team</p>
                </div>
                <a href="https://wpswapper.com/support" class="bg-brand-primary text-lg text-white px-4 py-1 rounded-lg font-bold">Ask Support</a>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <p class="text-xl font-bold">Documentation</p>
        <hr class="mt-2" />
        <p class="mt-2 text-lg text-brand-secondary">This is the best starting point to some of the most common issues.</p>
        <svg class="size-24 my-6 text-brand-secondary" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 160c16-63.16 76.43-95.41 208-96a15.94 15.94 0 0 1 16 16v288a16 16 0 0 1-16 16c-128 0-177.45 25.81-208 64c-30.37-38-80-64-208-64c-9.88 0-16-8.05-16-17.93V80a15.94 15.94 0 0 1 16-16c131.57.59 192 32.84 208 96m0 0v288"/></svg>
        <a class="bg-brand-primary text-lg text-white px-4 py-1 rounded-lg font-bold" href="#">Read The Documentation</a>
    </div>
</div>
