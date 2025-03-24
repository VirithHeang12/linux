<template>
    <Modal>
        <v-container class="mt-4">
            <v-card elevation="2" class="pa-4 rounded-lg">
                <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                    <v-row>
                        <v-col cols="12">
                            <vee-field name="format" v-slot="{ field, errors }">
                                <label class="text-subtitle-2 mb-1 d-block">Format</label>
                                <v-radio-group v-bind="field" :error-messages="errors" v-model="form.format" inline
                                    color="primary" class="mt-0 gender-radio-group">
                                    <v-radio label="EXCEL" value="excel" class="mr-6"></v-radio>
                                    <v-radio label="PDF" value="pdf" class="mr-6"></v-radio>
                                    <v-radio label="CSV" value="csv"></v-radio>
                                </v-radio-group>
                            </vee-field>
                        </v-col>
                    </v-row>

                    <v-row dense>
                        <v-col :cols="12" class="d-flex justify-end">
                            <v-btn color="primary" class="mt-4" size="large" :disabled="!meta.valid || form.processing"
                                @click.prevent="submitForm(setErrors)" :loading="form.processing">
                                Submit
                            </v-btn>
                        </v-col>
                    </v-row>
                </vee-form>
            </v-card>
        </v-container>
    </Modal>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import { route } from 'ziggy-js';

    const props = defineProps({
        itClass: {
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
    });


    const schema = yup.object().shape({
    });

    const form = useForm({
        format: 'excel',
    });


    /**
     * Submit the form
     *
     * @param setErrors
     *
     * @returns {void}
     */
    const submitForm = (setErrors) => {
        form.get(route('classes.generations.academics.students.export', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id,
        }), {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    }
</script>

<style scoped>
    .v-card {
        transition: all 0.3s ease;
    }

    .v-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }
</style>
