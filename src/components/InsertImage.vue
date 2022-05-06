<template>
    <form>
        <h2>Add Image</h2>
        <p v-if="status == 'error'">{{ message }}</p>
        <table>
            <tr>
                <td><label for="image">Image: </label></td>
                <td><input type="file" id="image" v-on:change="changeImage"></td>
            </tr>
            <tr>
                <td><label for="dateTaken">Date Taken: </label></td>
                <td><input type="date" id="dateTaken" v-model="dateTaken"></td>
            </tr>
            <tr>
                <td><label for="description">Description: </label></td>
                <td><textarea id="description" v-model="description"></textarea></td>
            </tr>
            <tr>
                <td><button type="submit" v-on:click.prevent="addImage">Add</button></td>
            </tr>
        </table>
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

<style scoped>
h2 {
    text-align: center;
}

table {
    margin: 0 auto;
    background-color: #2D728F;
    color: #71efeb;
    padding: 10px;
}
</style>