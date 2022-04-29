import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    username: "",
    auth: false,
    session: ""
  },
  getters: {
  },
  mutations: {
    setLogin: function(state, payload) {
      state.username = payload.username;
      state.auth = payload.auth;
      state.session = payload.session;
    }
  },
  actions: {
  },
  modules: {
  }
})
