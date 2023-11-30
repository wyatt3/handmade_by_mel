import './bootstrap';

import { createApp } from 'vue';

import Listings from './components/Listings.vue';
import Listing from './components/Listing.vue';
import ProductPage from './components/ProductPage.vue';

const app = createApp();

app
    .component('listings', Listings)
    .component('listing', Listing)
    .component('product-page', ProductPage)
    .mount('#app');
