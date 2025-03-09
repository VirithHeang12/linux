import "./bootstrap";

// Inertia
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, mdi } from 'vuetify/iconsets/mdi'


import '@mdi/font/css/materialdesignicons.css'
// Modal
import { Modal, putConfig, ModalLink, renderApp } from "@inertiaui/modal-vue";

// VeeValidate
import { Field, Form, ErrorMessage } from "vee-validate";

import DataTableServer from "./Components/DataTableServer.vue";

putConfig({
    type: "modal",
    navigate: false,
    modal: {
        closeButton: true,
        closeExplicitly: false,
        maxWidth: "2xl",
        paddingClasses: "p-4 sm:p-6",
        panelClasses: "bg-white rounded",
        position: "center",
    },
    slideover: {
        closeButton: true,
        closeExplicitly: false,
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
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(vuetify);

        app.component("vee-form", Form);
        app.component("vee-field", Field);
        app.component("vee-error", ErrorMessage);

        app.component("Modal", Modal);
        app.component("ModalLink", ModalLink);

        app.component("DataTableServer", DataTableServer);

        return app.mount(el);
    },
});
