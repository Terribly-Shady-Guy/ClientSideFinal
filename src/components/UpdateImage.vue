<template>
    <form>
        <label for="image">Image: </label>
        <input type="file" id="image" v-on:change="setPicture">
        <label for="description">description: </label>
        <textarea id="description" v-model="description"></textarea>
        <label for="dateTaken">Date Taken: </label>
        <input type="date" id="dateTaken" v-model="dateTaken">
        <button type="submit" v-on:click.prevent="updateImage">Update</button>
    </form>
</template>

<script>
import store from "@/store/index";
export default {
    data: function() {
        return {
            picture: null,
            description: "",
            dateTaken: "",
            status: "",
            message: ""
        };
    },
    computed: {
        session: function() {
            return store.state.session;
        }
    },
    methods: {
        getImage: async function() {
            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getImage.php";
            var currentSession = this.session;

            const response = await fetch(url, {
                method: 'POST',
                body: {
                    session: currentSession
                }
            });

            const data = await response.json();

            if (data.status == "succes") {
                this.picture = data.picture;
                this.description = data.description;
                this.dateTaken = data.dateTaken;
            }
        },
        updateImage: async function() {
            var formData = new FormData();

            formData.append("picture", this.picture);
            formData.append("description", this.description);
            formData.append("dateTaken", this.dateTaken);
            formData.append("session", this.session);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/updateImage.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            this.status = data.status;

            if (data.status == "success") {
                this.$router.push("/photodisplay");
            } else {
                this.message = data.message;
            }
        },
        setPicture: function(event) {
            this.picture = event.target.files[0];
        }
    }
}
</script>

<style scoped>

</style>