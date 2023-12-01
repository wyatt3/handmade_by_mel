import './bootstrap';

import { createApp } from 'vue';
import { store } from './store';

import Cart from './components/cart/Cart.vue';
import CartButton from './components/CartButton.vue';
import Listing from './components/Listing.vue';
import Listings from './components/Listings.vue';
import ProductPage from './components/ProductPage.vue';

const app = createApp();

app
    .use(store)
    .component('cart', Cart)
    .component('cart-button', CartButton)
    .component('listing', Listing)
    .component('listings', Listings)
    .component('product-page', ProductPage)
    .mount('#app');
