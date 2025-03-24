<template>
    <v-card class="mb-4 d-flex align-center">
        <v-card-title>Class: {{ itClass?.name }}</v-card-title>
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
    <v-expansion-panels class="mb-3">
        <v-expansion-panel>
            <v-expansion-panel-title>
                <v-icon left>mdi-filter</v-icon>
                <span class="ml-4">Filter</span>
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <v-row dense>
                    <v-col cols="12" md="12">
                        <v-text-field v-model.lazy="filter.generation" label="Generation" clearable variant="outlined"
                            hide-details>
                        </v-text-field>
                    </v-col>
                    <v-col :cols="12">
                        <v-btn class="mt-3" color="black" @click="filterCallback">
                            <v-icon left>mdi-filter</v-icon>
                            Filter
                        </v-btn>
                    </v-col>
                </v-row>
            </v-expansion-panel-text>
        </v-expansion-panel>
    </v-expansion-panels>
    <data-table-server :showNo="true" title="Generations" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="false" :has-import="false" :has-edit="false" :has-delete="false" @view="showCallback" />
</template>

<script setup>
    import { computed, ref } from "vue";
    import { router } from "@inertiajs/vue3";
    import { route } from "ziggy-js";

    const props = defineProps({
        itClassGenerations: {
            type: Object,
            required: true,
        },
        itClass: {
            type: Object,
            required: true,
        },
    });

    const serverItems = computed(() => {
        return props.itClassGenerations?.data || [];
    });
    const totalItems = computed(() => {
        return props.itClassGenerations?.meta?.total || 0;
    });

    const itemsPerPage = computed(() => {
        return props.itClassGenerations?.meta?.per_page || 5;
    });

    const loading = ref(false);

    const headers = [
        {
            title: "Generation",
            align: "start",
            sortable: true,
            key: "generation",
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
        { title: "Generations", disabled: true, href: "#" },
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
            only: ["itClassGenerations"],
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
                generation: item.id,
            }),
            {
                method: "get",
                preserveState: true,
                preserveScroll: true,
            }
        );
    };
</script>
