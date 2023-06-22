import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const state = {
    isLoggedIn: !!localStorage.getItem("token"),
    user: null,
    produtosNoCarrinho: [],
    isLoading: false
}

export const store = new Vuex.Store({
    state,
    getters: {
        user: (state) => {
            return state.user
        },
        isLoggedIn: (state) => {
            return state.isLoggedIn
        },
        isLoading: (state) => {
            return state.isLoading
        },
        produtosNoCarrinho: (state) => {
            return state.produtosNoCarrinho
        }
    },
    actions: {
        user(context, user) {
            context.commit('user', user)
        },
        isLoggedIn(context, isLoggedIn)
        {
            context.commit('isLoggedIn', isLoggedIn)
        },
        isLoading(context, isLoading)
        {
            context.commit('isLoading', isLoading)
        },
        produtosNoCarrinho(context, produtosNoCarrinho)
        {
            context.commit('produtosNoCarrinho',produtosNoCarrinho)
        }
    },
    mutations: {
        user(state,user) {
            state.user = user
        },
        isLoggedIn(state, isLoggedIn)
        {
            state.isLoggedIn = isLoggedIn
        },
        isLoading(state, isLoading)
        {
            state.isLoading = isLoading
        },
        produtosNoCarrinho(state, produtosNoCarrinho)
        {
            state.produtosNoCarrinho = produtosNoCarrinho
        }
    }
});

export default store;