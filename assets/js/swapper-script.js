htmx.onLoad(function() {
    document.body.addEventListener('htmx:afterSwap', function(evt) {
        var xhr = evt.detail.xhr;

        console.log('DOM state before swap:', document.body.innerHTML);

        if (xhr.getResponseHeader('X-Component-Changed-Header')) {
            var newHeaderElement = document.getElementById('changed-header');
            if (newHeaderElement) {
                var newHeader = newHeaderElement.innerHTML;
                var currentHeader = document.querySelector('header');
                if (currentHeader) {
                    currentHeader.innerHTML = newHeader;
                    console.log('Header updated:', currentHeader.innerHTML);
                } else {
                    console.error('Header element not found');
                }
                newHeaderElement.remove();
            } else {
                console.error('Changed header element not found');
            }
        }

        console.log('DOM state after swap:', document.body.innerHTML);
    });
});

