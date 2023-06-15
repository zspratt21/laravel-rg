import './bootstrap';
import jQuery from 'jquery';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

window.$ = jQuery;
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
