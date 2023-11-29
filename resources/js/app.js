import './bootstrap';

import { createApp } from 'vue';

import Listings from './components/Listings.vue';
import Listing from './components/Listing.vue';

const app = createApp();

app
    .component('listings', Listings)
    .component('listing', Listing)
    .mount('#app');
