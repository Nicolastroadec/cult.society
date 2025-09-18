document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        makeACFFieldsCopyable()

    }, 1000)
})

function makeACFFieldsCopyable() {
    const lfFieldsName = document.querySelectorAll('.li-field-name');

    const fields = [];

    lfFieldsName.forEach(field => {
        if (field.innerText && field.innerText !== 'Nom') {
            const fieldValue = field.innerText.trim();
            const phpDeclaration = `\$${fieldValue} = get_field('${fieldValue}');`;
            fields.push(phpDeclaration);
        }
    });

    if (fields.length === 0) {
        console.warn("No fields found.");
        return;
    }

    const acfFieldGroup = document.querySelector('#acf-field-group-fields');
    if (!acfFieldGroup) {
        console.warn("Element #acf-field-group-fields not found.");
        return;
    }

    // Create the copy container
    const copyable = document.createElement('div');
    copyable.classList.add('copyable-elements');
    copyable.style.position = 'relative';
    copyable.style.padding = '10px';
    copyable.style.border = '1px solid #ccc';
    copyable.style.background = '#f9f9f9';
    copyable.style.cursor = 'pointer';
    copyable.style.whiteSpace = 'pre-wrap'; // Keeps the format of the copied text

    // Create the text container
    const textContent = document.createElement('pre'); // Keeps formatting
    textContent.innerText = fields.join("\n"); // Join all fields in a single block
    textContent.style.margin = '0';
    textContent.style.userSelect = 'none'; // Prevent text selection by default

    // Create the "Copy" button
    const copyButton = document.createElement('button');
    copyButton.innerText = "Copy";
    copyButton.style.position = 'absolute';
    copyButton.style.top = '5px';
    copyButton.style.right = '5px';
    copyButton.style.padding = '5px 10px';
    copyButton.style.cursor = 'pointer';
    copyButton.style.background = '#007bff';
    copyButton.style.color = 'white';
    copyButton.style.border = 'none';
    copyButton.style.borderRadius = '5px';

    // Copy function with fallback
    function copyToClipboard() {
        const textToCopy = fields.join("\n");

        if (navigator.clipboard && navigator.clipboard.writeText) {
            // Modern method
            navigator.clipboard.writeText(textToCopy).then(() => {
                showCopySuccess();
            }).catch(err => {
                console.error("Clipboard API failed, using fallback.", err);
                fallbackCopy(textToCopy);
            });
        } else {
            // Fallback method
            fallbackCopy(textToCopy);
        }
    }

    // Fallback using execCommand
    function fallbackCopy(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
        showCopySuccess();
    }

    // Show visual feedback
    function showCopySuccess() {
        copyButton.innerText = "Copied!";
        copyButton.style.background = '#28a745'; // Success color
        setTimeout(() => {
            copyButton.innerText = "Copy";
            copyButton.style.background = '#007bff';
        }, 1500);
    }

    // Prevent page reload on button click
    copyButton.addEventListener('click', (event) => {
        event.preventDefault(); // Stops default behavior (form submission)
        event.stopPropagation(); // Prevents the event from bubbling up
        copyToClipboard();
    });

    copyable.addEventListener('click', copyToClipboard);

    // Append elements
    copyable.appendChild(textContent);
    copyable.appendChild(copyButton);
    acfFieldGroup.appendChild(copyable);
}
