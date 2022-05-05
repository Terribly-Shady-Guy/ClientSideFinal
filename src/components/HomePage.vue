<template>
    <div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Labore, consequuntur aperiam. Unde laudantium rerum consequatur dicta maiores, quidem iste in magnam quia molestiae ducimus cupiditate aliquam tempore voluptate inventore consequuntur.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores pariatur dolore eum voluptatum. Debitis facilis impedit, nobis delectus ex explicabo ipsa mollitia velit perspiciatis vitae perferendis, libero harum consectetur quia!</p>
        <div id="wrapper">
            <div v-for="(image, index) in images" :key="index" class="photoCard">
                <img v-bind:src="require('@/assets/portfolio_images/' + image.Picture)">
                <p>{{ image.Description }}</p>
                <p>Date taken: {{ image.DateTaken }}</p>
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
#wrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.photoCard img {
    width: 70%;
    height: 200px;
}
</style>