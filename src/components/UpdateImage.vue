<template>
    <div>
        <form>
            <label for="image">Image: </label>
            <input type="file" id="image" v-on:change="setPicture">
            <label for="description">description: </label>
            <textarea id="description" v-model="description"></textarea>
            <label for="dateTaken">Date Taken: </label>
            <input type="date" id="dateTaken" v-model="dateTaken">
            <button type="submit" v-on:click.prevent="updateImage">Update</button>
        </form>
        <img v-if="picture != null" v-bind:src="require('@/assets/portfolio_images/' + picture)">
    </div>
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
        },
        portId: function() {
            return store.state.portID;
        }
    },
    created: function() {
        this.getImage();
    },
    methods: {
        getImage: async function() {
            var formData = new FormData();

            formData.append("session", this.session);
            formData.append("portID", this.portId);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getImage.php";

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status == "success") {
                this.picture = data.picture;
                this.description = data.description;
                this.dateTaken = data.dateTaken;
            }
        },
        updateImage: async function() {
            var formData = new FormData();

            formData.append("portID", this.portId);
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