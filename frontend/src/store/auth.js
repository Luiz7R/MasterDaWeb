const state = {
    user: null,
    isLoggedIn: false
  };
  
  const mutations = {
    setUser(state, user) {
      state.user = user;
      state.isLoggedIn = true;
    },
    logout(state) {
      state.user = null;
      state.isLoggedIn = false;
    }
  };
  
  const actions = {
    login({ commit }, userCredentials) {
      commit('setUser', user);
    },
    logout({ commit }) {
      commit('logout');
    }
  };
  
  export default {
    state,
    mutations,
    actions
  };
  