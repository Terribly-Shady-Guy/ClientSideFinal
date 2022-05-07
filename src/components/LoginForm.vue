<template>
    <form id="loginForm" v-show="currentRoute != 'signup'">
        <div v-if="!auth">
            <p v-if="status == 'error'" id="errorMessage">{{ message }}</p>
            <div><input type="text" placeholder="Enter username" v-model="username"></div>
            <div><input type="password" placeholder="Enter password" v-model="password"></div>
            <div>
                <button type="submit" id="login" v-on:click.prevent="login">Log in</button>
                <router-link to="/signup">Sign Up</router-link>
            </div>
        </div>
        <div v-else id="loggedInDiv">
            <p>Welcome {{ loggedInUsername }}!</p>
            <button type="submit" id="logout" v-on:click.prevent="logout">Log out</button>
            <router-link to="/edituser">Edit Account</router-link>
        </div>
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
        },
        currentRoute: function() {
            return this.$route.name;
        }
    },
    methods: {
        login: async function() {
            var formData = new FormData();

            formData.append("username", this.username);
            formData.append("password", this.password);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/login.php";

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

            if (this.currentRoute != "home") {
                this.$router.push("/");
            }
        }
    }
}
</script>

<style scoped>
#loginForm {
    width: 45%;
    float: left;
    margin-right: 5px;
}

#loginForm div {
    width: 100%;
    margin-top: 5px;
    margin-bottom: 5px;
}

#loginForm input, #login, #loginForm a {
    float: right;
}

#loginForm a {
    margin-right: 45px;
}

#loginForm p {
    margin: 5px;
    text-align: right;
}

#loginForm a:hover {
    color: #c2b6ed;
}

#loggedInDiv button {
    margin-top: 16px;
    margin-left: 5px;
    float: right;
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