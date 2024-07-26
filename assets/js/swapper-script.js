htmx.onLoad(function() {
    document.body.addEventListener('htmx:afterSwap', function(evt) {
        var xhr = evt.detail.xhr;

        if (xhr.getResponseHeader('X-Component-Changed-Header')) {
            console.log('X-Component-Changed-Header is present in the response');

            var newHeaderElements = document.querySelectorAll('#changed-header');
            console.log('newHeaderElements:', newHeaderElements);

            if (newHeaderElements.length > 1) {
                console.error('Multiple elements with ID "changed-header" found');
                newHeaderElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            } else if (newHeaderElements.length === 1) {
                var newHeaderElement = newHeaderElements[0];
                var newHeader = newHeaderElement.innerHTML;
                console.log('newHeader:', newHeader);
                var currentHeader = document.querySelector('header');
                console.log('currentHeader:', currentHeader);

                if (currentHeader) {
                    currentHeader.innerHTML = newHeader;
                    htmx.process(currentHeader);
                } else {
                    console.error('Header element not found');
                }
                newHeaderElement.remove();
            } else {
                console.error('Changed header element not found');
            }
        }
    });
});
