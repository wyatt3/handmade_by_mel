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
import ConfirmModal from './components/admin/ConfirmModal.vue';
import ProductList from './components/admin/ProductList.vue';
import OrderList from './components/admin/OrderList.vue';

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
    .component('confirm-modal', ConfirmModal)
    .component('product-list', ProductList)
    .component('order-list', OrderList)
    .mount('#app');
