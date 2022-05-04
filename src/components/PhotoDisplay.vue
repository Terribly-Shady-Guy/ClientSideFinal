<template>
    <div>
        <h2>Welcome to your photography portfolio {{ username }}!</h2>
        <router-link to="/insertimage">Add Image</router-link>
        <h3 v-if="status == 'error'">{{ message }}</h3>
        <div class="photoCard" v-for="image in images" :key="image.PortID">
            <img v-bind:src="require('@/assets/portfolio_images/' + image.Picture)">
            <p>{{ image.Description }}</p>
            <p>{{ image.DateTaken }}</p>
            <p>{{ image.UploadDate }}</p>
            <form>
                <button type="submit" v-on:click.prevent="updateImage">Update</button>
                <button type="submit" v-on:click.prevent="deleteImage">Delete</button>
                <input type="hidden" v-bind:value="image.PortID">
            </form>
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
.photoCard {
    width: 30%;
    display: grid;
}

.photoCard img {
    width: 70%;
    height: 200px;
}
</style>