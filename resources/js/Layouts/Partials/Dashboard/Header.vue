<template>
    <v-app-bar :elevation="0" color="#242424f1" flat compact class="relative app-bar" style="z-index: 1;">
        <template v-slot:image>
            <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
        </template>
        <v-menu transition="scale-transition">
            <template v-slot:activator="{ props }">
                <v-btn icon v-bind="props" class="ml-3">
                    <v-icon>mdi-menu</v-icon>
                </v-btn>
            </template>

            <v-list style="background: linear-gradient(to top right, rgba(19,84,122,0.8), rgba(128,208,199,0.8));">
                <v-list-item v-for="(item, index) in items" :key="index" :to="item.route" @click="handleRoute(item)">
                    <div class="items-center justify-center d-flex">
                        <v-list-item>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </div>
                </v-list-item>
            </v-list>
        </v-menu>
        <v-app-bar-title>Royal University Of Phnom Penh</v-app-bar-title>
        <v-spacer></v-spacer>
        <v-img src="/assets/logo.png" alt="Logo" class="ml-auto mr-3" max-height="60" max-width="60"></v-img>
    </v-app-bar>
</template>

<script setup>

    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';

    const items = ref([
        { title: 'Home', icon: 'mdi-home', route: 'index' },
        { title: 'Logout', icon: 'mdi-logout', route: 'logout' },
    ]);

    const handleRoute = (item) => {
        if (item.route === 'logout') {
            router.post(route(item.route));
            return;
        }
        router.get(route(item.route));
    }

</script>
