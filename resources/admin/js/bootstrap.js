window._ = require("lodash");

try {
    // Load Popper and jQuery
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    // Load Bootstrap
    window.bootstrap = require("bootstrap");

    // Load Fontawesome
    require("@fortawesome/fontawesome-free");
    // require("@fortawesome/fontawesome-free/js/all");

    // Load Filepond, jQuery Filepond and Filepond Plugins
    window.FilePond = require("filepond");
    require("jquery-filepond/filepond.jquery.js");

    window.FilePondPluginImagePreview = require("filepond-plugin-image-preview");
    window.FilePondPluginMediaPreview = require("filepond-plugin-media-preview");
    window.FilePondPluginImageExifOrientation = require("filepond-plugin-image-exif-orientation");
    window.FilePondPluginFileValidateSize = require("filepond-plugin-file-validate-size");
    window.FilePondPluginFileValidateType = require("filepond-plugin-file-validate-type");
    window.FilePondPluginImageCrop = require("filepond-plugin-image-crop");
    window.FilePondPluginImageResize = require("filepond-plugin-image-resize");
    window.FilePondPluginImageTransform = require("filepond-plugin-image-transform");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
