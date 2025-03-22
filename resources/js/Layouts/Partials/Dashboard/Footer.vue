<template>
    <v-footer app class="footer-bar" height="auto">
        <div class="gradient-overlay"></div>
        <div class="d-flex justify-center align-center w-100 py-3">
            <div class="text-center text-white font-weight-medium">
                {{ new Date().getFullYear() }} - Royal University Of Phnom Penh
            </div>
        </div>
    </v-footer>
</template>

<script setup>
    // No additional script needed for basic footer
</script>

<style scoped>
    .footer-bar {
        position: relative;
        background: transparent !important;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        z-index: 1;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .gradient-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, #26a4c5, #0e64b4);
        z-index: -1;
    }
</style>
