<template>
  <div>
        <h2>Edit Account Info</h2>
        <form>
            <p v-if="status != 'success'">{{ message }}</p>
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" v-model="username" v-bind:class="formValidation.usernameValid? 'valid' : 'invalid'"></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" v-model="password" v-bind:class="formValidation.passwordValid? 'valid' : 'invalid'"></td>
                </tr>
                <tr>
                    <td><label for="firstName">First Name:</label></td>
                    <td><input type="text" id="firstName" v-model="firstName" v-bind:class="formValidation.firstNameValid? 'valid' : 'invalid'"></td>
                </tr>
                <tr>
                    <td><label for="lastName">Last Name:</label></td>
                    <td><input type="text" id="lastName" v-model="lastName" v-bind:class="formValidation.lastNameValid? 'valid' : 'invalid'"></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="text" id="email" v-model="email" v-bind:class="formValidation.emailValid? 'valid' : 'invalid'"></td>
                </tr>
                <tr>
                    <td><button type="submit" v-on:click.prevent="updateUser">Edit</button></td>
                </tr>
            </table>
        </form>
        <ul>
            <li v-show="!passwordValidaton.isMinLength">Password must be at least 6 characters</li>
            <li v-show="!passwordValidaton.hasUppercase">Password must contain at least 1 upper case letter</li>
            <li v-show="!passwordValidaton.hasLowercase">Password must contain at least 1 lower case letter</li>
            <li v-show="!passwordValidaton.hasDigit">Password must contain at least 1 number</li>
            <li v-show="!passwordValidaton.hasSpecialChar">Password must contain at least 1 special character</li>
            <li>Leave password blank if you don't want to change it</li>
        </ul>
    </div>
</template>

<script>
import store from "@/store/index";

export default {
    data: function() {
        return {   
            username: "",
            password: "",
            firstName: "",
            lastName: "",
            email: "",
            status: "",
            message: "",
            passwordValidaton: {
                isMinLength: false,
                hasDigit: false,
                hasUppercase: false,
                hasLowercase: false,
                hasSpecialChar: false
            },
            formValidation: {
                usernameValid: false,
                passwordValid: true,
                firstNameValid: false,
                lastNameValid: false,
                emailValid: false
            }
        }
    },
    computed: {
        session: function() {
            return store.state.session;
        }
    },
    created: function() {
        this.getUser();
    },
    methods: {
        getUser: async function() {
            var formData = new FormData();

            formData.append("session", this.session);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getUser.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            this.status = data.status;

            if (data.status == "success") {
                this.username = data.username;
                this.firstName = data.firstName;
                this.lastName = data.lastName;
                this.email = data.email;
            } else {
                this.message = data.message;
            }
        },
        updateUser: async function() {
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;

            if (pattern.test(this.password) || this.password == "") {
                let formData = new FormData();

                formData.append("session", this.session);
                formData.append("username", this.username);
                formData.append("password", this.password);
                formData.append("firstName", this.firstName);
                formData.append("lastName", this.lastName);
                formData.append("email", this.email);

                const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/updateUser.php";

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                this.status = data.status;

                if (data.status == "success") {
                    this.$router.push("/");
                } else {
                    this.message = data.message;
                }
            }
        }
    },
    watch: {
        password: function() {
            var password = this.password;

            if (password != "") {
                this.passwordValidaton.isMinLength = password.length >= 6;
                this.passwordValidaton.hasLowercase = /(?=.*[a-z])/.test(password);
                this.passwordValidaton.hasUppercase = /(?=.*[A-Z])/.test(password);
                this.passwordValidaton.hasDigit = /(?=.\d)/.test(password);
                this.passwordValidaton.hasSpecialChar = /(?=.*[!@#$%^&*])/.test(password);
            } else {
                this.passwordValidaton.isMinLength = false;
                this.passwordValidaton.hasLowercase = false;
                this.passwordValidaton.hasUppercase = false;
                this.passwordValidaton.hasDigit = false;
                this.passwordValidaton.hasSpecialChar = false;
            }

             var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;

             if (pattern.test(password) || password == "") {
                 this.formValidation.passwordValid = true;
             } else {
                 this.formValidation.passwordValid = false;
             }
        },
        username: function() {
            if (this.username != "") {
                this.formValidation.usernameValid = true;
            } else {
                this.formValidation.usernameValid = false;
            }
        },
        firstName: function() {
            if (this.firstName != "") {
                this.formValidation.firstNameValid = true;
            } else {
                this.formValidation.firstNameValid = false;
            }
        },
        lastName: function() {
            if (this.lastName != "") {
                this.formValidation.lastNameValid = true;
            } else {
                this.formValidation.lastNameValid = false;
            }
        },
        email: function() {
            if (this.email != "") {
                this.formValidation.emailValid = true;
            } else {
                this.formValidation.emailValid = false;
            }
        }
    }
}
</script>

<style>
table {
    margin: 0 auto;
    background-color: #2D728F;
    color: #71efeb;
    padding: 10px;
}

label {
    text-align: left;
}

ul {
    text-align: center;
    color: red;
    list-style-type: none;
}

h2 {
    text-align: center;
}
</style>