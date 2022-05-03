<template>
    <form>
        <label for="image">Image: </label>
        <input type="file" id="image" v-on:change="changeImage">
        <label for="description">Description: </label>
        <textarea id="description" v-model="description"></textarea>
        <label for="dateTaken">Date Taken: </label>
        <input type="date" id="dateTaken" v-model="dateTaken">
        <button type="submit" v-on:click.prevent="addImage">Add</button>
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
        }
    },
    computed: {
        session: function() {
            return store.state.session;
        }
    },
    methods: {
        addImage: async function() {
            var formData = new FormData();

            formData.append("picture", this.picture);
            formData.append("description", this.description);
            formData.append("dateTaken", this.dateTaken);
            formData.append("session", this.session);

            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/addImage.php";

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
        changeImage: function(event) {
            this.picture = event.target.files[0];
        }
    }
}
</script>
