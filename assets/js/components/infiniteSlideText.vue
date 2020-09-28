<template>
    <div class="banderole">
        <infinite-slide-bar duration="100s">
            <div class="banderole--items">
                <div v-for="(message, key) in messages" :key="key">
                    <div class="f-left pd-t-8px mg-r-10px">
                        <p>{{ message }}</p>
                    </div>
                </div>
            </div>
        </infinite-slide-bar>
    </div>
</template>

<script>

import InfiniteSlideBar from 'vue-infinite-slide-bar'

export default {
    components: { InfiniteSlideBar },
    data() {
        return{
            messages: [
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',
                'Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,Quisque gravida vulputate mi non suscipit. Vivamus placerat quam sit amet lectus pretium accumsan. Praesent ut mi condimentum,',                                                                
            ]
        }
    }
}
</script>
