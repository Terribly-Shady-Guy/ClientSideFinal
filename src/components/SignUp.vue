<template>
    <div>
        <form>
            <p v-if="status != 'success'">{{ message }}</p>
            <label for="username">Username: </label>
            <input type="text" id="username" v-model="user.username">
            <label for="password">Password: </label>
            <input type="password" id="password" v-model="user.password">
            <label for="firstName">First Name: </label>
            <input type="text" id="firstName" v-model="user.firstName">
            <label for="lastName">Last Name: </label>
            <input type="text" id="lastName" v-model="user.lastName">
            <label for="email">Email: </label>
            <input type="text" id="email" v-model="user.email">
            <button type="submit" v-on:click.prevent="signUp">Sign Up</button>
        </form>
        <ul>
            <li v-show="!passwordValidaton.isMinLength">Password must be at least 6 characters</li>
            <li v-show="!passwordValidaton.hasUppercase">Password must contain at least 1 upper case letter</li>
            <li v-show="!passwordValidaton.hasLowercase">Password must contain at least 1 lower case letter</li>
            <li v-show="!passwordValidaton.hasDigit">Password must contain at least 1 number</li>
            <li v-show="!passwordValidaton.hasSpecialChar">Password must contain at least 1 special character</li>
        </ul>
    </div>
</template>

<script>
export default {
    data: function() {
        return {   
            user: {
                username: "",
                password: "",
                firstName: "",
                lastName: "",
                email: ""
            },
            status: "",
            message: "",
            passwordValidaton: {
                isMinLength: false,
                hasDigit: false,
                hasUppercase: false,
                hasLowercase: false,
                hasSpecialChar: false
            }
        };
    },
    methods: {
        signUp: async function() {
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;
            var user = this.user;

            if (pattern.test(user.password)) {
                let formData = new FormData();

                formData.append("username", user.username);
                formData.append("password", user.password);
                formData.append("firstName", user.firstName);
                formData.append("lastName", user.lastName);
                formData.append("email", user.email);

                const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/signup.php";

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                this.status = data.status;

                if (data.status == "success") {
                    user.username = "";
                    user.password = "";
                    user.firstName = "";
                    user.lastName = "";
                    user.email = "";

                    this.$router.push("/");
                } else {
                    this.message = data.message;
                }
            }
        }
    },
    watch: {
        password: function() {
            var validObject = this.passwordValidaton;
            var password = this.user.password;

            if (password != "") {
                validObject.isMinLength = password.length > 6;
                validObject.hasLowercase = /(?=.*[a-z])/.test(password);
                validObject.hasUppercase = /(?=.*[A-Z])/.test(password);
                validObject.hasDigit = /(?=.\d)/.test(password);
                validObject.hasSpecialChar = /(?=.*[!@#$%^&*])/.test(password);
            } else {
                validObject.isMinLength = false;
                validObject.hasLowercase = false;
                validObject.hasUppercase = false;
                validObject.hasDigit = false;
                validObject.hasSpecialChar = false;
            }
        }
    }
}
</script>

<style scoped>

</style>