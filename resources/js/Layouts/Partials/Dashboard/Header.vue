<template>
    <v-app-bar :elevation="0" color="#242424f1" flat compact class="relative app-bar" style="z-index: 1;">
        <template v-slot:image>
            <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
        </template>

        <template v-slot:prepend>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title>Title</v-app-bar-title>
    </v-app-bar>

</template>
