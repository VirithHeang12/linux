<template>
    <v-app-bar flat class="header-bar" height="70">
        <template v-slot:image>
            <v-img gradient="to right, #26a4c5, #0e64b4"></v-img>
        </template>

        <v-menu transition="scale-transition" location="bottom">
            <template v-slot:activator="{ props }">
                <v-btn v-bind="props" icon variant="text" color="white" class="ml-3">
                    <v-icon>mdi-menu</v-icon>
                </v-btn>
            </template>

            <v-list class="menu-list" elevation="3" rounded="lg">
                <v-list-item v-for="(item, index) in items" :key="index" :to="item.route" @click="handleRoute(item)"
                    rounded class="mb-1" color="rgba(38, 164, 197, 0.08)">
                    <template v-slot:prepend>
                        <v-icon class="me-2" :color="'#209ab9'">{{ item.icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>

        <v-app-bar-title class="text-white font-weight-medium">Royal University Of Phnom Penh</v-app-bar-title>

        <v-spacer></v-spacer>

        <div class="university-logo me-3">
            <v-img src="/assets/logo.png" alt="Logo" width="50" height="50" class="rounded-circle"></v-img>
        </div>
    </v-app-bar>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';

    const items = ref([
        { title: 'Profile', icon: 'mdi-account-circle', route: 'profile' },
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

<style scoped>
    .header-bar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .university-logo {
        border-radius: 50%;
        padding: 2px;
    }

    .menu-list {
        background: white;
        border-radius: 12px;
        padding: 8px;
        min-width: 200px;
    }
</style>
