<template>
    <div>
        <h2>Thank you for joining us</h2>
        <form>
            <p v-if="status != 'success'">{{ message }}</p>
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" v-model="username"></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" v-model="password"></td>
                </tr>
                <tr>
                    <td><label for="firstName">First Name:</label></td>
                    <td><input type="text" id="firstName" v-model="firstName"></td>
                </tr>
                <tr>
                    <td><label for="lastName">Last Name:</label></td>
                    <td><input type="text" id="lastName" v-model="lastName"></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="text" id="email" v-model="email"></td>
                </tr>
                <tr>
                    <td><button type="submit" v-on:click.prevent="signUp">Sign Up</button></td>
                </tr>
            </table>
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
            }
        }
    },
    methods: {
        signUp: async function() {
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;

            if (pattern.test(this.password)) {
                let formData = new FormData();

                formData.append("username", this.username);
                formData.append("password", this.password);
                formData.append("firstName", this.firstName);
                formData.append("lastName", this.lastName);
                formData.append("email", this.email);

                const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/signup.php";

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                this.status = data.status;

                if (data.status == "success") {
                    this.username = "";
                    this.password = "";
                    this.firstName = "";
                    this.lastName = "";
                    this.email = "";

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
        }
    }
}
</script>

<style scoped>
table {
    margin: 0 auto;
    background-color: #2D728F;
    color: #c2b6ed;
}

label {
    text-align: left;
}

ul {
    text-align: center;
    color: red;
}

h2 {
    text-align: center;
}
</style>