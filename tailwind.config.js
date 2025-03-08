/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/@inertiaui/modal-vue/src/**/*.{js,vue}",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
