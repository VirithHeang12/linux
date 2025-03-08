import './bootstrap';

// Inertia
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// VeeValidate
import { Field, Form, ErrorMessage } from 'vee-validate'

const vuetify = createVuetify({
    components,
    directives,
})

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify);

        app.component('vee-form', Form)
        app.component('vee-field', Field)
        app.component('vee-error', ErrorMessage)

        return app.mount(el)
    },
})
