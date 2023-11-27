import './bootstrap';

import { createApp } from 'vue';

import Listings from './components/Listings.vue';

const app = createApp();

app
    .component('listings', Listings)
    .mount('#app');
