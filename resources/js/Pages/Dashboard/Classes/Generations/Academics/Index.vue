<template>
    <v-card class="mb-4 d-flex align-center">
        <v-card-title>Class: {{ itClass?.name }} Generation: {{ generation.data.generation }}</v-card-title>
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
        :has-create="false" :has-import="false" :has-edit="false" :has-delete="false" @view="showCallback" />
</template>

<script setup>
    import { computed, ref } from "vue";
    import { router } from "@inertiajs/vue3";
    import { route } from "ziggy-js";

    const props = defineProps({
        itClassGenerationAcademics: {
            type: Object,
            required: true,
        },
        itClass: {
            type: Object,
            required: true,
        },
        generation: {
            type: Object,
            required: true,
        },
    });

    const serverItems = computed(() => {
        return props.itClassGenerationAcademics?.data || [];
    });
    const totalItems = computed(() => {
        return props.itClassGenerationAcademics?.meta?.total || 0;
    });

    const itemsPerPage = computed(() => {
        return props.itClassGenerationAcademics?.meta?.per_page || 5;
    });

    const loading = ref(false);

    const headers = [
        {
            title: "Room No",
            align: "start",
            sortable: true,
            key: "room",
        },
        {
            title: "Year",
            align: "start",
            sortable: true,
            key: "year",
        },
        {
            title: "Start Date",
            align: "start",
            sortable: true,
            key: "start_date",
        },
        {
            title: "End Date",
            align: "start",
            sortable: true,
            key: "end_date",
        },
    ];

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
        { title: "Academics", disabled: true, href: "#" },
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
     * Show callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const showCallback = (item) => {
        router.visit(
            route("classes.generations.academics.students.index", {
                class: props.itClass.id,
                generation: props.generation.data.id,
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
