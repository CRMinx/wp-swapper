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

        if (xhr.getResponseHeader('X-Component-Changed-Footer-Scripts')) {
            var newFooterScriptElements = document.querySelectorAll('#changed-footer-scripts');

            //newFooterScriptElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            var newFooterScripts = newFooterScriptElements[0].querySelectorAll('script');

            var currentFooterScriptsContainer = document.querySelector('body');

            var oldFooterScripts = currentFooterScriptsContainer.querySelectorAll('script');
            oldFooterScripts.forEach(script => script.remove());

            function copyAttributes(oldScript, newScript) {
                Array.from(oldScript.attributes).forEach(attr => {
                    newScript.setAttribute(attr.name, attr.value);
                });
            }

            function appendScriptsSequentially(scripts, index) {
                if (index >= scripts.length) {
                    document.dispatchEvent(new Event("htmx:beforeSwap"));
                    return;
                }

                var script = scripts[index];
                var newScriptElement = document.createElement('script');
                copyAttributes(script, newScriptElement);

                if (script.src) {
                    newScriptElement.src = script.src;
                    newScriptElement.onload = function() {
                        appendScriptsSequentially(scripts, index + 1);
                    };
                    currentFooterScriptsContainer.appendChild(newScriptElement);
                } else {
                    newScriptElement.textContent = script.textContent;
                    currentFooterScriptsContainer.appendChild(newScriptElement);
                    appendScriptsSequentially(scripts, index + 1);
                }
            }

            appendScriptsSequentially(newFooterScripts, 0);

            while (newFooterScriptElements > 0) {
                newFooterScriptElements[0].remove();
            }
        }


        document.addEventListener('htmx:beforeSwap', function(event) {
        if (xhr.getResponseHeader('X-Component-Changed-Head')) {
            var newHeadElements = document.querySelectorAll('#changed-head');

            if (newHeadElements.length > 1) {
                newHeadElements.forEach((el, index) => console.log(`Element ${index}:`, el));
            } else if (newHeadElements.length === 1) {
                var newHead = newHeadElements[0];

                document.head.innerHTML = newHead.innerHTML;

                newHead.remove();
            }
        }
        });
    });
});
