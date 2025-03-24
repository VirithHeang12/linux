<template>
    <div class="table-container">
        <v-data-table-server density="comfortable" :disable-sort="true" @update:options="updateOptionsCallback"
            :items="items" :items-length="itemsLength" v-model:items-per-page="itemsPerPage" :headers="computedHeaders"
            :loading="loading" :items-per-page-options="itemsPerPageOptions">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title class="fw-semibold !text-2xl !text-zinc-800">{{ title }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn v-if="hasExport" type="button" color="brown-darken-4" class="m-2 fw-medium !tracking-normal"
                        variant="outlined" @click="exportItem()">
                        Export
                    </v-btn>
                    <v-btn v-if="hasCreate" @click="createItem()" class="m-2 fw-medium !tracking-normal"
                        prepend-icon="mdi-plus" color="primary" variant="outlined"> {{ title }}
                    </v-btn>
                </v-toolbar>
            </template>

            <template v-slot:[`item.no`]="{ item }" v-if="showNo">
                {{ item.no }}
            </template>

            <template v-slot:[`item.image`]="{ item }">
                <v-avatar size="40" color="grey" class="me-3">
                    <v-img style="cursor: pointer;" :src="item.image?.path" @click="viewImage(item.image?.path)" />
                </v-avatar>
            </template>

            <template v-slot:[`item.actions`]="{ item }">
                <div class="w-20 d-flex justify-content-center">
                    <v-icon v-if="hasShow" class="me-3" color="primary" size="small" @click="viewItem(item)">
                        mdi-eye
                    </v-icon>
                    <v-icon v-if="hasEdit" class="me-3" color="secondary" size="small" @click="editItem(item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon v-if="hasDelete" class="me-3" color="danger" size="small" @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                </div>
            </template>
            <template v-slot:no-data>
                <p>There is no data to display</p>
            </template>
        </v-data-table-server>
    </div>
</template>

<script setup>
    import { computed, ref } from 'vue';

    const props = defineProps({
        hasExport: {
            type: Boolean,
            required: false,
            default: false,
        },
        hasCreate: {
            type: Boolean,
            required: false,
            default: true,
        },
        hasEdit: {
            type: Boolean,
            required: false,
            default: true,
        },
        hasDelete: {
            type: Boolean,
            required: false,
            default: true,
        },
        hasShow: {
            type: Boolean,
            required: false,
            default: true,
        },
        showNo: {
            type: Boolean,
            required: false,
            default: false,
        },
        title: {
            type: String,
            required: true,
        },
        serverItems: {
            type: Array,
            required: true,
        },
        itemsLength: {
            type: Number,
            required: true,
        },
        itemsPerPage: {
            type: Number,
            required: false,
            default: 10,
        },
        loading: {
            type: Boolean,
            required: false,
            default: false,
        },
        itemValue: {
            type: String,
            required: false,
            default: 'id',
        },
        headers: {
            type: Array,
            required: true,
        },
    });

    const itemsPerPage = ref(props.itemsPerPage);
    const page = ref(0);

    const items = computed(() => {
        if (props.showNo) {
            return props.serverItems.map((item, index) => {
                return {
                    no: ((page.value - 1) * itemsPerPage.value) + index + 1,
                    ...item,
                };
            });
        } else {
            return props.serverItems;
        }
    });

    const computedHeaders = computed(() => {
        if (props.showNo) {
            return [
                {
                    title: 'No',
                    align: 'start',
                    sortable: false,
                    value: 'no',
                },
                ...props.headers,
                {
                    title: 'Actions',
                    align: 'start',
                    sortable: false,
                    value: 'actions',
                },
            ];
        } else {
            return [
                ...props.headers,
                {
                    title: 'Actions',
                    align: 'start',
                    sortable: false,
                    value: 'actions',
                },
            ];
        }
    });

    const itemsPerPageOptions = [5, 10, 20, 30, 40, 50];

    const emits = defineEmits(['view', 'edit', 'delete', 'create', 'export', 'update:options']);

    const updateOptionsCallback = (options) => {
        page.value = options.page;
        emits('update:options', options);
    };

    const viewItem = (item) => {
        emits('view', item);
    };

    const editItem = (item) => {
        emits('edit', item);
    };

    const deleteItem = (item) => {
        emits('delete', item);
    };

    const createItem = () => {
        emits('create');
    };

    const viewImage = (path) => {
        window.open(path, '_blank');
    };

    const exportItem = () => {
        emits('export');
    };
</script>

<style scoped></style>
