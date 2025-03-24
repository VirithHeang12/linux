<template>

    <Head :title="title" />
    <v-app>
        <template v-if="isAdmin">
            <DashboardHeader />
        </template>
        <template v-else>
            <StudentHeader />
        </template>
        <v-main class="d-flex align-start justify-center bg-neutral-50" style="min-height: 300px;">
            <v-container fluid class="px-5">
                <slot>
                    Main content
                </slot>
            </v-container>
        </v-main>
        <template v-if="isAdmin">
            <DashboardFooter />
        </template>
        <template v-else>
            <StudentFooter />
        </template>
    </v-app>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';
    import DashboardFooter from './Partials/Dashboard/Footer.vue';
    import DashboardHeader from './Partials/Dashboard/Header.vue';
    import StudentFooter from './Partials/Student/Footer.vue';
    import StudentHeader from './Partials/Student/Header.vue';

    const { props } = usePage();

    const isAdmin = computed(() => {
        return props.auth?.user?.is_admin;
    });

    defineProps({
        title: {
            type: String,
            default: 'Group 2',
        },
    });
</script>
