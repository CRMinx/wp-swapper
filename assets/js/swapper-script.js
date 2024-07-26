htmx.onLoad(function() {
    document.body.addEventListener('htmx:afterSwap', function(evt) {
        var xhr = evt.detail.xhr;

        if (xhr.getResponseHeader('X-Component-Changed-Header')) {

            var newHeaderElements = document.querySelectorAll('#changed-header');

            if (newHeaderElements.length > 1) {
                newHeaderElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            } else if (newHeaderElements.length === 1) {
                var newHeaderElement = newHeaderElements[0];
                var newHeader = newHeaderElement.innerHTML;
                var currentHeader = document.querySelector('header');

                if (currentHeader) {
                    currentHeader.innerHTML = newHeader;
                    htmx.process(currentHeader);
                } else {
                    console.error('Header element not found');
                }
                newHeaderElement.remove();
            }
        }

        if (xhr.getResponseHeader('X-Component-Changed-Footer')) {

            var newFooterElements = document.querySelectorAll('#changed-footer');

            if (newFooterElements.length > 1) {
                newFooterElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            } else if (newFooterElements.length === 1) {
                var newFooterElement = newFooterElements[0];
                var newFooter = newFooterElement.innerHTML;
                var currentFooter = document.querySelector('footer');

                if (currentFooter) {
                    currentFooter.innerHTML = newFooter;
                    htmx.process(currentFooter);
                } else {
                    console.error('Footer element not found');
                }
                newFooterElement.remove();
            }
        }

        if (xhr.getResponseHeader('X-Component-Changed-Body')) {
            var newBodyElements = document.querySelectorAll('#changed-body');

            if (newBodyElements.length > 1) {
                newBodyElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            } else if (newBodyElements.length === 1) {
                var newBody = newBodyElements[0];
                var attributesDiv = newBody.querySelector('div');

                while (document.body.attributes.length > 0) {
                    document.body.removeAttribute(document.body.attributes[0].name);
                }

                Array.from(attributesDiv.attributes).forEach(attr => {
                    document.body.setAttribute(attr.name, attr.value);
                });

                newBody.remove();
            }
        }
    });
});
