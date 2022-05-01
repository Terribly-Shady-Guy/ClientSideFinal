<template>
    <div>
        <button type="submit">Add Image</button>
        <h2>Welcome to your photography portfolio {{ username }}!</h2>
        <h3 v-if="status == 'error'">{{ message }}</h3>
        <div class="photoCard" v-for="image in images" :key="image.PortID">
            <img v-bind:src="image.Picture">
            <p>{{ image.Description }}</p>
            <p>{{ image.DateTaken }}</p>
            <p>{{ image.UploadDate }}</p>
            <form class="modify">
                <button type="submit">Update</button>
                <button type="submit">Delete</button>
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
    methods: {
        getImages: async function() {
            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getImages.php";
            var currentSession = this.session;

            const response = await fetch(url, {
                method: 'POST',
                body: {
                    session: currentSession
                }
            });

            const data = await response.json();
            
            this.status = data.status;

            if (data.status == "success") {
                this.images = data.images;
            } else {
                this.message = data.message;
            }
        }
    }
}
</script>

<style scoped>

</style>