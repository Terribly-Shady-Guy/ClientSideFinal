import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    username: "",
    auth: false,
    session: "",
    portID: ""
  },
  getters: {
  },
  mutations: {
    setLogin: function(state, payload) {
      state.username = payload.username;
      state.auth = payload.auth;
      state.session = payload.session;
    },
    setLogout: function(state) {
      state.username = "";
      state.auth = false;
    },
    setPortID: function(state, payload) {
      state.portID = payload.portID;
    }
  },
  actions: {
  },
  modules: {
  }
})
