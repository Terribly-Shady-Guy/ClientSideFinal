<template>
  <div id="app">
    <header>
      <h1>Digital Photography Portfolio</h1>
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/photodisplay">Portfolio</router-link>
        <router-link to="/about">About</router-link>
      </nav>
      <login-form/>
    </header>
    <router-view/>
  </div>
</template>

<script>
import LoginForm from "@/components/LoginForm.vue";

export default {
  name: "login-form",
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
  text-align: center;
  color: #2c3e50;
}

h1 {
    text-align: center;
}

nav {
  width: 50%;
  float: left;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  width: 20%;
  padding: 20px;
  display: block;
  float: left;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
