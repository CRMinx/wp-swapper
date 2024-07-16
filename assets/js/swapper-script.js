document.addEventListener('DOMContentLoaded', function() {
    // Insert opening div after the header
    var header = document.querySelector('header');
    if (header) {
        header.insertAdjacentHTML('afterend', '<div id="swapper-site-content" hx-boost="true">');
    }

    // Insert closing div before the footer
    var footer = document.querySelector('footer');
    if (footer) {
        footer.insertAdjacentHTML('beforebegin', '</div>');
    }
});

