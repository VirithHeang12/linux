<template>

    <Head :title="title" />
    <v-app>
        <Header />
        <v-main class="bg-neutral-50">
            <v-container fluid class="fill-height pa-0">
                <slot>
                    Main content
                </slot>
            </v-container>
        </v-main>
        <Footer />
    </v-app>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import Footer from './Partials/Student/Footer.vue';
    import Header from './Partials/Student/Header.vue';

    defineProps({
        title: {
            type: String,
            default: 'Group 2',
        },
    });
</script>

<style>

    /* Global style to remove unwanted scrollbars */
    html,
    body {
        overflow-y: auto;
        overflow-x: hidden;
        height: 100%;
    }

    .v-application {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .v-main {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }
</style>
