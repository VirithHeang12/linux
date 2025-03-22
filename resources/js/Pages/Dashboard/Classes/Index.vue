<template>
    <v-expansion-panels class="mb-3">
        <v-expansion-panel>
            <v-expansion-panel-title>
                <v-icon left>mdi-filter</v-icon>
                <span class="ml-4">Filter</span>
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <v-row dense>
                    <v-col cols="12" md="3">
                        <v-text-field v-model.lazy="filter.first_name" label="First Name" clearable variant="outlined"
                            hide-details>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field v-model.lazy="filter.last_name" label="Last Name" clearable variant="outlined"
                            hide-details>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field v-model.lazy="filter.phone" label="Phone" clearable variant="outlined"
                            hide-details>
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field v-model.lazy="filter.email" label="Email" clearable variant="outlined"
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
    import { toast } from 'vue3-toastify';

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
        return props.itClasses?.per_page || 10;
    });

    const loading = ref(false);

    const filter = ref({
        name: route().params.filter?.first_name ?? null,
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
        router.get(route('classes.generations.index', item.id), {}, {
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
            },
        });
    };
</script>
