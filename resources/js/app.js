import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import weatherWidget from './weather';

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.data('weatherWidget', weatherWidget);
Alpine.start();
