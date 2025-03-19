<template>
    <div>
        <h1>Index Page</h1>
    </div>

    <button @click="logoutCallback">Log out</button>
</template>


<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { onMounted } from 'vue';
import { toast } from 'vue3-toastify';

const logoutCallback = () => {
    router.post(route('logout'));
}

/**
 * Notify the user
 *
 * @param {string} message
 *
 * @return void
 */
const notify = (message) => {
    toast(message, {
        autoClose: 1500,
        position: toast.POSITION.BOTTOM_RIGHT,
    });
}

/**
 * On mounted
 *
 * @return void
 */
onMounted(() => {
    const message = usePage().props.flash.success;
    if (message) {
        notify(message);
    }
});
</script>
