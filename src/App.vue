<template>
  <div id="app">
    <header>
      <h1>Digital Photography Portfolio</h1>
      <div id="headerRow">
        <nav>
          <router-link to="/">Home</router-link>
          <router-link to="/photodisplay" v-if="auth">Portfolio</router-link>
          <router-link to="/about">About</router-link>
        </nav>
        <login-form/>
      </div>
    </header>
    <router-view/>
  </div>
</template>

<script>
import LoginForm from "@/components/LoginForm.vue";
import store from "@/store/index.js";

export default {
  computed: {
    auth: function() {
      return store.state.auth;
    }
  },
  name: "app",
  components: {
    LoginForm
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

body {
  width: 75%;
  margin: 0 auto;
  background-color: #F7FFF7;
  min-height: 100vh;
}

html {
  background-color: #9BF3F0;
}

h1 {
    text-align: center;
    margin: 0;
    padding: 30px;
}

header {
  background-color: #2D728F;
}

header h1 {
  color: #c2b6ed;
}

nav {
  width: 50%;
  float: left;
}

nav a {
  font-weight: bold;
  color: #2D728F;
  width: 20%;
  padding: 30px;
  display: block;
  float: left;
  text-align: center;
}

nav a:hover {
  background-color: rgb(71, 49, 152, 0.2);
}

#headerRow {
  background-color: #DAFFED;
}

nav a.router-link-exact-active {
  background-color: #c2b6ed;
}

header::after, #headerRow::after {
  display: block;
  clear: both;
  content: "";
}
</style>
