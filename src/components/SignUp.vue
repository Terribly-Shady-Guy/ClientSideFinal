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
            <li v-show="/^[A-Z]*$/.test(password)">Password must contain at least 1 upper case letter</li>
            <li v-show="/^[a-z]*$/.test(password)">Password must contain at least 1 lower case letter</li>
            <li v-show="/^[0-9]*$/.test(password)">Password must contain at least 1 number</li>
            <li v-show="/^[!@#$%^&*]*$/.test(password)">Password must contain at least 1 special character</li>
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
            isValidPassword: false
        };
    },
    methods: {
        signUp: function() {
            if (this.isValidPassword) {
                let vm = this;
                let formData = new FormData();

                formData.append("username", vm.username);
                formData.append("password", vm.password);
                formData.append("firstName", vm.firstName);
                formData.append("lastName", vm.lastName);
                formData.append("email", vm.email);

                fetch("http://localhost/tylerkaufmannfinal/src/php/signup.php", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(function(data) {
                    vm.status = data.status;

                    if (data.status == "success") {
                        vm.username = "";
                        vm.password = "";
                        vm.firstName = "";
                        vm.lastName = "";
                        vm.email = "";

                        vm.$router.push("/");
                    } else {
                        vm.message = data.message;
                    }
                });
            }
        }
    },
    watch: {
        password: function() {
            let pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;
            this.isValidPassword = pattern.test(this.password);
        }
    }
}
</script>

<style scoped>

</style>