<template>
    <v-footer class="items-start justify-center d-flex flex-column"
        style="background: linear-gradient(to top right, rgba(19,84,122,0.8), rgba(128,208,199,0.8));" rounded="lg">
        <div class="px-4 py-2 d-flex w-100 align-center">
            <strong>Get connected with us on social networks!</strong>

            <div class="d-flex ga-2 ms-auto">
                <v-btn v-for="icon in icons" :key="icon" :icon="icon" size="large" variant="plain"></v-btn>
            </div>
        </div>

        <div class="px-4 py-2 text-center bg-black rounded-lg w-100">
            {{ new Date().getFullYear() }} — <strong>Royal University Of Phnom Penh</strong>
        </div>
    </v-footer>
</template>
<script setup>
const icons = [
    'mdi-facebook',
    'mdi-email',
    'mdi-instagram',
]
</script>
