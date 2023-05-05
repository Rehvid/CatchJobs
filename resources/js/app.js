import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';

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
