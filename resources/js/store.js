
import { createStore } from 'vuex'

let cart = window.localStorage.getItem('cart');
let count = window.localStorage.getItem('count');

export const store = createStore({
    state() {
        return {
            cart: cart ? JSON.parse(cart) : [],
            count: count ? parseInt(count) : 0
        }
    },
    mutations: {
        addToCart(state, product) {
            state.cart.push(product);
            state.count = state.cart.length;
            this.commit('saveCart');
        },
        removeFromCart(state, index) {
            state.cart.splice(index, 1);
            state.count = state.cart.length;
            this.commit('saveCart');
        },
        updateQuantity(state, index, quantity) {
            state.cart[index].quantity = quantity;
            this.commit('saveCart');
        },
        saveCart(state) {
            window.localStorage.setItem('cart', JSON.stringify(state.cart));
            window.localStorage.setItem('count', state.count);
        },
        resetCart(state) {
            state.cart = [];
            state.count = 0;
            this.commit('saveCart');
        }
    }
});
