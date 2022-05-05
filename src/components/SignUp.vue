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
            <li v-show="!passwordValidaton.hasMinLength">Password must be at least 6 characters</li>
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
                hasMinLength: false,
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

            if (pattern.test(this.user.password)) {
                let formData = new FormData();

                formData.append("username", this.user.username);
                formData.append("password", this.user.password);
                formData.append("firstName", this.user.firstName);
                formData.append("lastName", this.user.lastName);
                formData.append("email", this.user.email);

                const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/signup.php";

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                this.status = data.status;

                if (data.status == "success") {
                    this.user.username = "";
                    this.user.password = "";
                    this.user.firstName = "";
                    this.user.lastName = "";
                    this.user.email = "";

                    this.$router.push("/");
                } else {
                    this.message = data.message;
                }
            }
        }
    },
    watch: {
        password: function() {
            if (this.user.password != "") {
                this.passwordValidaton.hasMinLength = this.user.password.length > 6;
                this.passwordValidaton.hasLowercase = /(?=.*[a-z])/.test(this.user.password);
                this.passwordValidaton.hasUppercase = /(?=.*[A-Z])/.test(this.user.password);
                this.passwordValidaton.hasDigit = /(?=.\d)/.test(this.user.password);
                this.passwordValidaton.hasSpecialChar = /(?=.*[!@#$%^&*])/.test(this.user.password);
            } else {
                this.passwordValidaton.hasMinLength = false;
                this.passwordValidaton.hasLowercase = false;
                this.passwordValidaton.hasUppercase = false;
                this.passwordValidaton.hasDigit = false;
                this.passwordValidaton.hasSpecialChar = false;
            }
        }
    }
}
</script>

<style scoped>

</style>