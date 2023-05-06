import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import "@ckeditor/ckeditor5-build-classic/build/translations/pl.js";

window.Alpine = Alpine;

Alpine.start();


export function getDataFromServer(url) {
    if (!url) {
        return console.error('Url is not provided');
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]') || false;

    if (!csrfToken) {
        return  console.error('Csrf token is not found')
    }

    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken.getAttribute('content'),
        },
        method: 'get',
        credentials: "same-origin",
    })
}

export function createCKEditorForTextarea(element) {
    if (!element) {
        return console.error('Element is not valid');
    }

    ClassicEditor.create(element, {
        toolbar: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "outdent",
            "indent",
            "|",
            "blockQuote",
            "insertTable",
            "mediaEmbed",
            "undo",
            "redo"
        ],
        language: 'pl'
    });
}
