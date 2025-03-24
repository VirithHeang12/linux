<template>
    <v-card class="mb-4 d-flex align-center">
        <v-card-title>Student List of Year {{ props.academic.year }}, Generation
            {{ props.generation.name }}</v-card-title>
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
    <data-table-server :showNo="true" title="Generations" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="false" :has-import="false" :has-edit="false" :has-delete="false" @delete="deleteCallback" />
</template>

<script setup>
    import { computed, ref } from "vue";
    import { router } from "@inertiajs/vue3";
    import { route } from "ziggy-js";

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
        return props.itClassGenerationAcademics?.meta?.per_page || 10;
    });

    const loading = ref(false);

    const headers = [
        {
            title: "Student ID",
            align: "start",
            sortable: true,
            key: "id",
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
        { icon: "mdi-home", disabled: false, href: route("classes.index") },
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
                generation: props.generation.id,
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
     * Filter callback
     *
     * @return {void}
     */
    const filterCallback = () => {
        router.reload({
            only: ["itClassGenerationAcademics"],
            data: {
                page: 1,
                itemsPerPage: itemsPerPage.value,
                filter: {
                    generation: filter.value.generation,
                },
            },
        });
    };

    /**
     * Show callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const showCallback = (item) => {
        router.visit(
            route("classes.generations.academics.index", {
                class: props.itClass.id,
                generation: props.generation.id,
                academic: item.id,
            }),
            {
                method: "get",
                preserveState: true,
                preserveScroll: true,
            }
        );
    };
</script>
