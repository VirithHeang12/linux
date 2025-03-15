import "./bootstrap";

// Inertia
import { createApp, h } from "vue";
import { createInertiaApp, usePage } from "@inertiajs/vue3";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, mdi } from 'vuetify/iconsets/mdi'

// Vue Toast
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


import '@mdi/font/css/materialdesignicons.css'
// Modal
import { Modal, putConfig, ModalLink, renderApp } from "@inertiaui/modal-vue";

// VeeValidate
import { Field, Form, ErrorMessage } from "vee-validate";

import DataTableServer from "./Components/DataTableServer.vue";
import DashboardLayout from "./Layouts/DashboardLayout.vue";
import StudentLayout from "./Layouts/StudentLayout.vue";
import ImageUploader from "./Components/ImageUploader.vue";

putConfig({
    type: "modal",
    navigate: true,
    modal: {
        closeButton: true,
        closeExplicitly: true,
        maxWidth: "2xl",
        paddingClasses: "p-4 sm:p-6",
        panelClasses: "bg-white rounded",
        position: "center",
    },
    slideover: {
        closeButton: true,
        closeExplicitly: true,
        maxWidth: "md",
        paddingClasses: "p-4 sm:p-6",
        panelClasses: "bg-white min-h-screen",
        position: "right",
    },
});

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
});

createInertiaApp({
    resolve: (name) => {
        const isAdmin = usePage().props?.auth?.user?.is_admin;

        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        if (!page) {
            page = pages[`./Pages/Error.vue`]
        }
        if (name === "Auth/Login" || name === "Auth/Register") {
            page.default.layout = null;
            return page;
        }
        if (!isAdmin) {
            page.default.layout = StudentLayout
        } else {
            page.default.layout = DashboardLayout
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(
                Vue3Toastify,
                {
                    autoClose: 3000,
                }
            )
            .use(vuetify);

        app.component("vee-form", Form);
        app.component("vee-field", Field);
        app.component("vee-error", ErrorMessage);

        app.component("Modal", Modal);
        app.component("ModalLink", ModalLink);

        app.component("DataTableServer", DataTableServer);
        app.component("ImageUploader", ImageUploader);

        return app.mount(el);
    },
});
