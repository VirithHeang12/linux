<template>
    <v-card class="mb-4 d-flex align-center">
        <v-card-title>Classes</v-card-title>
        <v-spacer></v-spacer>
        <v-breadcrumbs :items="breadcrumbs">
            <template v-slot:item="{ item, index }">
                <v-breadcrumbs-item :href="item.href" :disabled="item.disabled">
                    <v-icon v-if="item.icon" :color="index === 0 ? 'primary' : undefined">{{ item.icon
                        }}</v-icon>
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
                        <v-text-field v-model.lazy="filter.name" label="Class Name" clearable variant="outlined"
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
    <data-table-server :showNo="true" title="Classes" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="false" :has-import="false" :has-edit="false" :has-delete="false" @view="showCallback" />
</template>

<script setup>
    import { computed, ref } from 'vue'
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';

    const props = defineProps({
        itClasses: {
            type: Object,
            required: true,
        }
    });

    const serverItems = computed(() => {
        return props.itClasses?.data || [];
    });
    const totalItems = computed(() => {
        return props.itClasses?.total || 0;
    });

    const itemsPerPage = computed(() => {
        return props.itClasses?.per_page || 5;
    });

    const loading = ref(false);

    const filter = ref({
        name: route().params.filter?.name ?? null,
    });

    const headers = [
        {
            title: 'Class Name',
            align: 'start',
            sortable: true,
            key: 'name',
        },
    ];

    /**
     * Breadcrumbs data
     *
     * @type {Array}
     */
    const breadcrumbs = ref([
        { title: 'Dashboard', disabled: false, href: '#' },
        { title: 'Classes', disabled: true, href: '#' },
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
        router.visit(route('classes.generations.index', {
            class: item.id,
        }), {
            method: 'get',
            preserveState: true,
            preserveScroll: true,
        });
    };

    /**
     * Filter callback
     *
     * @return {void}
     */
    const filterCallback = () => {
        router.reload({
            only: ["itClasses"],
            data: {
                page: 1,
                itemsPerPage: itemsPerPage.value,
                filter: {
                    name: filter.value.name,
                },
            },
        });
    };
</script>
