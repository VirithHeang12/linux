<template>
    <div>
        <h1>Index Page</h1>
    </div>

    <button @click="logoutCallback">Log out</button>
</template>


<script setup>
    import { router } from '@inertiajs/vue3';

    const logoutCallback = () => {
        router.post(route('logout'));
    }
</script>
