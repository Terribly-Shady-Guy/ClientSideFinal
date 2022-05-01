<template>
    <div>
        <form>
            <p v-if="status != 'success'">{{ message }}</p>
            <label for="username">Username: </label>
            <input type="text" id="username" v-model="username" required>
            <label for="password">Password: </label>
            <input type="password" id="password" v-model="password" required>
            <label for="firstName">First Name: </label>
            <input type="text" id="firstName" v-model="firstName" required>
            <label for="lastName">Last Name: </label>
            <input type="text" id="lastName" v-model="lastName" required>
            <label for="email">Email: </label>
            <input type="text" id="email" v-model="email" required>
            <button type="submit" v-on:click.prevent="signUp()">Sign Up</button>
        </form>
        <ul>
            <li v-show="password.length < 6">Password must be at least 6 characters</li>
            <li v-show="/(?=.*[A-Z])*$/.test(password)">Password must contain at least 1 upper case letter</li>
            <li v-show="/(?=.*[a-z])*$/.test(password)">Password must contain at least 1 lower case letter</li>
            <li v-show="/(?=.\d)*$/.test(password)">Password must contain at least 1 number</li>
            <li v-show="/(?=.*[!@#$%^&*])*$/.test(password)">Password must contain at least 1 special character</li>
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
            message: ""
        };
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
    }
}
</script>

<style scoped>

</style>