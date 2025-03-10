<template>
    <v-app-bar :elevation="0" color="#242424f1" flat compact class="relative z-1 app-bar"
        image="/assets/rupp-landscape.jpg">
        <template v-slot:image>
            <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
        </template>

        <template v-slot:prepend>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title>Title</v-app-bar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
    </v-app-bar>

</template>

<script setup>

</script>

<style scoped>
    .bg-blur::before {
        content: '';
        width: 65%;
        height: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, 100%);
        background-color: red;
        filter: blur(200px);
        border-radius: 100%;
        z-index: -1;
    }
</style>
