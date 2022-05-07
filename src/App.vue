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
  width: 20%;
  padding: 35px;
  display: block;
  float: left;
  text-align: center;
  text-decoration: none;
}

nav a:hover {
  background-color: rgb(71, 49, 152, 0.1);
}

a {
  color: #2D728F;
}

#headerRow {
  background-color: #DAFFED;
}

nav a.router-link-exact-active {
  background-color: #c2b6ed;
}

button {
  border-radius: 5px;
  padding: 4px;
  background-color: #9BF3F0;
  border-color: #71efeb;
}

.pictureValid {
  color: lightgreen;
}

.pictureInvalid {
  color: coral;
}

.valid {
  background-color: lightgreen;
}

.invalid {
  background-color: coral;
}

header::after, #headerRow::after {
  display: block;
  clear: both;
  content: "";
}
</style>
