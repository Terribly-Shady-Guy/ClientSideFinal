<template>
    <div>
        <div id="wrapper">
            <router-link to="/insertimage" v-if="auth">Add Image</router-link>
            <h2>Welcome to your photography portfolio {{ username }}!</h2>
        </div>
        <h3 v-if="status == 'error'">{{ message }}</h3>
        <div id="gridWrapper">
            <div class="photoCard" v-for="image in images" :key="image.PortID">
                <img v-bind:src="require('@/assets/portfolio_images/' + image.Picture)">
                <p>{{ image.Description }}</p>
                <p>Taken: {{ image.DateTaken }}</p>
                <p>Uploaded: {{ image.UploadDate }}</p>
                <form>
                    <button type="submit" v-on:click.prevent="updateImage">Update</button>
                    <button type="submit" v-on:click.prevent="deleteImage">Delete</button>
                    <input type="hidden" v-bind:value="image.PortID">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import store from "@/store/index.js";

export default {
    computed: {
        username: function() {
            return store.state.username;
        },
        session: function() {
            return store.state.session;
        },
        auth: function() {
            return store.state.auth;
        }
    },
    data: function() {
        return {
            images: [],
            status: "",
            message: ""
        }
    },
    created: function() {
        this.getImages();
    },
    methods: {
        getImages: async function() {
            var formData = new FormData();

            formData.append("session", this.session);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getImages.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            
            this.status = data.status;

            if (data.status == "success") {
                this.images = data.images;
            } else {
                this.message = data.message;
            }
        },
        deleteImage: async function(event) {
            var targetForm = event.target.form;
            var portID = targetForm.elements.item(2).value;

            var formData = new FormData();

            formData.append("portID", portID);
            formData.append("session", this.session);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/deleteImage.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            this.status = data.status;

            if (data.status == "success") {
                this.getImages();
            } else {
                this.message = data.message;
            }
        },
        updateImage: function(event) {
            var targetForm = event.target.form;
            var portID = targetForm.elements.item(2).value;

            store.commit("setPortID", { portID: portID });

            this.$router.push("/updateimage");
        }
    }
}
</script>

<style scoped>
h2 {
    width: 90%;
}

a {
    width: 10%;
    margin-top: 25px;
}

a:hover {
    color: #c2b6ed;
}

a, h2 {
    float: left;
}

a, h2, p, h3 {
    text-align: center;
}

div::after {
    clear: both;
    display: block;
    content: "";
}

#gridWrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(auto-fill, 350px);
}

.photoCard img {
    width: 70%;
    height: 200px;
    display: block;
    margin: 0 auto;
}

.photoCard form {
    display: flex;
    justify-content: center;
}

.photoCard form button {
    margin: 5px;
}
</style>