<template>
    <div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Labore, consequuntur aperiam. Unde laudantium rerum consequatur dicta maiores, quidem iste in magnam quia molestiae ducimus cupiditate aliquam tempore voluptate inventore consequuntur.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores pariatur dolore eum voluptatum. Debitis facilis impedit, nobis delectus ex explicabo ipsa mollitia velit perspiciatis vitae perferendis, libero harum consectetur quia!</p>
        <!--Will be used to show example images-->
        <div class="row">
            <div v-for="index in 4" :key="index" class="photoCard">
                <img src="@/assets/Photo_placeholder.png">
                <p>This is a placeholder for example photos.</p>
                <p>Date taken: yyyy-mm-dd</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.photoCard {
    float: left;
    margin: 30px;
    text-align: center;
}

.row {
    display: flex;
    justify-content: center;
}
</style>