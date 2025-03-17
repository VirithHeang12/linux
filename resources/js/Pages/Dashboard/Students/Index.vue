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
    <data-table-server :showNo="true" title="Student" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="true" @view="viewCallback" @delete="deleteCallback" @edit="editCallback"
        @create="createCallback" />
</template>

<script setup>
    import { computed, ref, watch } from 'vue'
    import { router, usePage } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';
    import { visitModal } from '@inertiaui/modal-vue';
    import { toast } from 'vue3-toastify';

    const props = defineProps({
        students: {
            type: Object,
            required: true,
        }
    });

    const serverItems = computed(() => {
        return props.students?.data || [];
    });
    const totalItems = computed(() => {
        return props.students?.total || 0;
    });

    const itemsPerPage = computed(() => {
        return props.students?.per_page || 10;
    });

    const loading = ref(false);

    const filter = ref({
        first_name: route().params.filter?.first_name ?? null,
        last_name: route().params.filter?.last_name ?? null,
        phone: route().params.filter?.phone ?? null,
        email: route().params.filter?.email ?? null,
    });

    const headers = [
        {
            title: 'Image',
            align: 'start',
            sortable: true,
            key: 'image',
        },
        {
            title: 'Student ID',
            align: 'start',
            sortable: true,
            key: 'student_id',
        },
        {
            title: 'First Name',
            align: 'start',
            sortable: true,
            key: 'first_name',
        },
        {
            title: 'Last Name',
            align: 'start',
            sortable: true,
            key: 'last_name',
        },
        {
            title: 'Gender',
            align: 'start',
            sortable: true,
            key: 'gender',
        },
        {
            title: 'Birth Date',
            align: 'start',
            sortable: true,
            key: 'date_of_birth',
        },
        {
            title: 'Address',
            align: 'start',
            sortable: true,
            key: 'address',
        },
        {
            title: 'Email',
            align: 'start',
            sortable: true,
            key: 'email',
        },
        {
            title: 'Phone',
            align: 'start',
            sortable: true,
            key: 'phone',
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
     * View callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const viewCallback = (item) => {
        router.get(route('students.show', {
            student: item.id,
        }));
    };

    /**
     * Edit callback
     *
     * @param {Object} item
     *
     * @return {void}
     */
    const editCallback = (item) => {
        router.get(route('students.edit', {
            student: item.id,
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
        visitModal(route('students.delete', {
            student: item.id,
        }));

    };

    /**
     * Create callback
     *
     * @return {void}
     */
    const createCallback = () => {
        visitModal(route('students.create'));
    };

    /**
     * Filter callback
     *
     * @return {void}
     */
    const filterCallback = () => {
        router.reload({
            only: ["students"],
            data: {
                filter: filter.value,
                page: 1,
                itemsPerPage: itemsPerPage.value,
            },
        });
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
