<template>
    <div id="homeViewWrapper">
        <h3>Welcome!</h3>
        <p>Welcome to the Digital Photography Portfolio. Here you can upload any photos you took and build an album of your own.</p>
        <p>To get started, create a free account and log in! With an account, you can upload your favorite photos to your heart's content!</p>
        <div id="wrapper">
            <h3>Photos uploaded by other users</h3>
            <div id="gridWrapper">
                <div v-for="(image, index) in images" :key="index" class="photoCard">
                    <img v-bind:src="require('@/assets/portfolio_images/' + image.Picture)">
                    <p>{{ image.Description }}</p>
                    <p>Date taken: {{ image.DateTaken }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            images: []
        }
    },
    created: function() {
        this.getSampleImages();
    },
    methods: {
        getSampleImages: async function() {
            const url = "http://localhost/Client-Side_Programming/tylerkaufmannfinal/src/php/getSampleImages.php";

            const response = await fetch(url);
            const data = await response.json();
            
            if (data.status == "success") {
                this.images = data.images;
            } else {
                console.log(data.message);
            }
        }
    }
}
</script>

<style scoped>
#gridWrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.photoCard img {
    width: 100%;
    height: 200px;
}

.photoCard {
    text-align: center;
}

h3 {
    text-align: center;
}

#homeViewWrapper {
    position: relative;
    min-height: 72vh;
}

#wrapper {
    position: absolute;
    bottom: 0;
}
</style>