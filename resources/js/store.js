
import { createStore } from 'vuex'

let cart = window.localStorage.getItem('cart');
let count = window.localStorage.getItem('count');
let subTotal = window.localStorage.getItem('subTotal');

export const store = createStore({
    state() {
        return {
            cart: cart ? JSON.parse(cart) : [],
            count: count ? parseInt(count) : 0,
            subTotal: subTotal ? parseFloat(subTotal) : 0
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
        updateQuantity(state, params) {
            state.cart[params.index].quantity = params.quantity;
            this.commit('saveCart');
        },
        updateSubTotal(state) {
            state.subTotal = 0;
            state.cart.forEach(function (item) {
                item.subTotal = item.unit_price * item.quantity;
                state.subTotal += item.subTotal;
            });
            window.localStorage.setItem('subTotal', state.subTotal);
        },
        saveCart(state) {
            this.commit('updateSubTotal');
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
