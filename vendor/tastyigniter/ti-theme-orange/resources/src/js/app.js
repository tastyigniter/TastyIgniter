import $ from 'jquery';
import Popper from 'popper.js/dist/umd/popper';
import intlTelInput from 'intl-tel-input';
import PhotoSwipeLightbox from 'photoswipe/lightbox';

window.bootstrap = require('bootstrap');

window.$ = window.jQuery = $;

window.Popper = Popper;
window.Swal = require('sweetalert2/dist/sweetalert2.js');
window.intlTelInput = intlTelInput;

window.currency = require('currency.js');
require('jquery-raty-js');
require('flatpickr')

window.PhotoSwipe = require('photoswipe');
window.PhotoSwipeLightbox = PhotoSwipeLightbox;

require('./partials/scripts');
require('./partials/cookie-banner');
require('./partials/telephone');

