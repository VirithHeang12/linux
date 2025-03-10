<template>

    <Head :title="title" />
    <v-app>
        <Header />
        <v-main class="d-flex align-start justify-center bg-neutral-50" style="min-height: 300px;">
            <v-container>
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
            default: 'Eternal',
        },
    });
</script>
