<template>
    <form id="loginForm">
        <fieldset v-if="!auth">
            <p v-if="status == 'error'" id="errorMessage">{{ message }}</p>
            <div><input type="text" placeholder="Enter username" v-model="username"></div>
            <div><input type="password" placeholder="Enter password" v-model="password"></div>
            <div>
                <button type="submit" v-on:click.prevent="login()">Log in</button>
                <router-link to="/signup">Sign Up</router-link>
            </div>
        </fieldset>
        <fieldset v-else>
            <p>Welcome {{ loggedInUsername }}!</p>
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
        },
        loggedInUsername: function() {
            return store.state.username;
        }
    },
    methods: {
        login: async function() {
            var formData = new FormData();

            formData.append("username", this.username);
            formData.append("password", this.password);

            const url = "http://localhost/tylerkaufmannfinal/src/php/login.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            this.status = data.status;

            if (data.status == "success") {
                store.commit("setLogin", data);

                this.username = "";
                this.password = "";
            } else {
                this.message = data.message;
            }
        },
        logout: function() {
            store.commit("setLogout");
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