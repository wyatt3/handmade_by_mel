import './bootstrap';

import { createApp } from 'vue';
import { store } from './store';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

import Cart from './components/cart/Cart.vue';
import CartButton from './components/CartButton.vue';
import Listing from './components/Listing.vue';
import Listings from './components/Listings.vue';
import ProductPage from './components/ProductPage.vue';

//admin components
import ProductList from './components/admin/ProductList.vue';

const app = createApp();

app
    .use(store)
    .use(ToastPlugin)
    .component('cart', Cart)
    .component('cart-button', CartButton)
    .component('listing', Listing)
    .component('listings', Listings)
    .component('product-page', ProductPage)
    //admin components
    .component('product-list', ProductList)
    .mount('#app');
