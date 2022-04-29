<template>
    <form id="loginForm">
        <fieldset v-if="!store.state.auth">
            <p v-if="status == 'error'" id="errorMessage">{{ message }}</p>
            <div><input type="text" placeholder="Enter username" v-model="username"></div>
            <div><input type="password" placeholder="Enter password" v-model="password"></div>
            <div>
                <button type="submit" v-on:click.prevent="login()">Log in</button>
                <router-link to="/signup">Sign Up</router-link>
            </div>
        </fieldset>
        <fieldset v-else>
            <p>Welcome {{ store.state.username }}!</p>
            <button type="submit" v-on:click.prevent="logout()">Log out</button>
        </fieldset>
    </form>
</template>

<script>
import store from "@/store/index.js";

export default {
    data: function() {
        return {
            username: "",
            password: "",
            status: "",
            message: ""
        };
    },
    computed: {
        auth: function() {
            return store.state.auth;
        }
    },
    methods: {
        login: function() {
            let vm = this;
            let formData = new FormData();

            formData.append("username", vm.username);
            formData.append("password", vm.password);

            fetch("http://localhost/tylerkaufmannfinal/src/php/login.php", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(function(data) {
                vm.status = data.status;

                if (data.status == "success") {
                    store.state.username = data.username;
                    store.state.auth = data.auth;
                    store.state.session = data.session;

                    vm.username = "";
                    vm.password = "";
                } else {
                    vm.message = data.message;
                }
            });
        },
        logout: function() {
            store.state.auth = false;
            store.state.username = "";
        }
    }
}
</script>

<style scoped>
#loginForm {
width: 50%;
float: left;
}

#loginForm div {
    width: 100%;
    margin-bottom: 5px;
}

#loginForm input, #loginForm button, #loginForm a {
    float: right;
}

#loginForm a {
    margin-right: 45px;
}

#loginForm div::after {
    clear: both;
    display: block;
    content: "";
}

#errorMessage {
    color: red;
}
</style>