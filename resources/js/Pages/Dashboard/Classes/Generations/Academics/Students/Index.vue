<template>
    <v-card class="mb-4 d-flex align-center">
        <v-card-title>Class: {{ itClass?.name }} Generation: {{ generation.data.generation }} Academic: {{
            academic.data?.year }} Room: {{ academic.data?.room }}</v-card-title>
        <v-spacer></v-spacer>
        <v-breadcrumbs :items="breadcrumbs">
            <template v-slot:item="{ item, index }">
                <v-breadcrumbs-item :href="item.href" :disabled="item.disabled">
                    <v-icon v-if="item.icon" :color="index === 0 ? 'primary' : undefined">{{ item.icon }}</v-icon>
                    <span v-else>{{ item.title }}</span>
                </v-breadcrumbs-item>
            </template>
            <template v-slot:divider>
                <v-icon icon="mdi-chevron-right"></v-icon>
            </template>
        </v-breadcrumbs>
    </v-card>
    <data-table-server :showNo="true" title="Students" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="true" :has-show="true" :has-import="false" :has-export="true" :has-edit="false" :has-delete="true"
        @delete="deleteCallback" @create="createCallback" @view="showCallback" @export="exportCallback" />
</template>

<script setup>
    import { computed, ref, watch } from "vue";
    import { router, usePage } from "@inertiajs/vue3";
    import { route } from "ziggy-js";
    import { visitModal } from '@inertiaui/modal-vue';
    import { toast } from 'vue3-toastify';

    const props = defineProps({
        itClassGenerationAcademicStudents: {
            type: Object,
            required: true,
        },
        generation: {
            type: Object,
            required: true,
        },
        academic: {
            type: Object,
            required: true,
        },
        itClass: {
            type: Object,
            required: true,
        },
    });

    const serverItems = computed(() => {
        return props.itClassGenerationAcademicStudents?.data || [];
    });
    const totalItems = computed(() => {
        return props.itClassGenerationAcademicStudents?.meta?.total || 0;
    });

    const itemsPerPage = computed(() => {
        return props.itClassGenerationAcademicStudents?.meta?.per_page || 5;
    });

    const loading = ref(false);

    const headers = [
        {
            title: "Student ID",
            align: "start",
            sortable: true,
            key: "student_id",
        },
        {
            title: "First Name",
            align: "start",
            sortable: true,
            key: "first_name",
        },
        {
            title: "Last Name",
            align: "start",
            sortable: true,
            key: "last_name",
        },
        {
            title: "Date of Birth",
            align: "start",
            sortable: true,
            key: "date_of_birth",
        },
    ];

    const filter = ref({
        generation: route().params.filter?.generation ?? null,
    });

    /**
     * Breadcrumbs data
     *
     * @type {Array}
     */
    const breadcrumbs = ref([
        { title: 'Dashboard', disabled: false, href: route("classes.index") },
        { title: "Classes", disabled: false, href: route("classes.index") },
        {
            title: "Generations",
            disabled: false,
            href: route("classes.generations.index", {
                class: props.itClass.id,
            }),
        },
        {
            title: "Academics",
            disabled: false,
            href: route("classes.generations.academics.index", {
                class: props.itClass.id,
                generation: props.generation.data.id,
            }),
        },
        { title: "Students", disabled: true, href: "#" },
    ]);


    /**
     * Load items from the server
     *
     * @param {Object} options
     * @param {Number} options.page
     * @param {Number} options.itemsPerPage
     *
     * @return {void}
     */
    function loadItems({ page, itemsPerPage }) {
        router.reload({
            data: {
                page,
                itemsPerPage,
            },
        });
    }

    /**
     * Create callback
     *
     * @return {void}
     */
    const createCallback = () => {
        router.get(route('classes.generations.academics.students.create', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id,
        }));
    };


    /**
     * Delete callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const deleteCallback = (item) => {
        visitModal(route('classes.generations.academics.students.delete', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id,
            student: item.id,
        }));
    }

    /**
     * Export callback
     *
     * @return {void}
     */
    const exportCallback = () => {
        visitModal(route('classes.generations.academics.students.export.form', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id,
        }));
    }


    /**
     * Show callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const showCallback = (item) => {
        router.visit(
            route("classes.generations.academics.students.show", {
                class: props.itClass.id,
                generation: props.generation.data.id,
                academic: props.academic.data.id,
                student: item.id,
            }),
            {
                method: "get",
                preserveState: true,
                preserveScroll: true,
            }
        );
    };


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

    const page = usePage();

    /**
     * Watch for flash messages
     *
     * @return void
     */
    watch(() => page.props.flash, (flash) => {
        const success = page.props.flash.success;
        const error = page.props.flash.error;

        if (success) {
            notify(success);
        } else if (error) {
            notify(error);
        }
    }, {
        deep: true,
    });
</script>
