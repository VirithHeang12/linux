<template>
    <data-table-server :showNo="true" title="Student" :serverItems="serverItems" :items-length="totalItems"
        :headers="headers" :loading="loading" :items-per-page="itemsPerPage" item-value="id" @update:options="loadItems"
        :has-create="true" @view="viewCallback" @delete="deleteCallback" @edit="editCallback"
        @create="createCallback" />
</template>

<script setup>
    import { computed, ref } from 'vue'
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';
    import { visitModal } from '@inertiaui/modal-vue';

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

    const headers = [
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
     * @param {Array} options.sortBy
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

    const viewCallback = (item) => {
        visitModal(route('students.show', {
            student: item.id,
        }), {
            method: 'get',
            config: {
                slideover: false,
                position: 'center',
                closeExplicitly: true,
                maxWidth: '2xl',
            },
        });

    };

    const editCallback = (item) => {
        visitModal(route('students.edit', {
            student: item.id,
        }), {
            method: 'get',
            config: {
                slideover: true,
                position: 'right',
                closeExplicitly: true,
                maxWidth: '2xl',
            },
        });
    };

    const deleteCallback = (item) => {
        visitModal(route('students.delete', {
            student: item.id,
        }), {
            config: {
                slideover: false,
                position: 'center',
                closeExplicitly: true,
                maxWidth: '2xl',
            },

        });

    };

    const createCallback = () => {
        visitModal(route('students.create'), {
            config: {
                slideover: true,
                position: 'right',
                closeExplicitly: true,
                maxWidth: '2xl',
            },

        });
    };
</script>
