<template>
    <v-container>
        <v-row>
            <v-col cols="12" class="d-flex align-center mb-4">
                <v-btn color="secondary" variant="outlined" class="me-4" prepend-icon="mdi-arrow-left"
                    @click="backCallback">
                    Back
                </v-btn>
                <h3 class="text-h5 font-weight-bold mb-0">Register Student</h3>
            </v-col>
        </v-row>

        <v-card elevation="2" class="pa-4 rounded-lg">
            <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                <v-row dense>
                    <v-col :cols="12" :md="12" class="mt-2">
                        <vee-field name="student_ids" v-slot="{ field: { value, ...field }, errors }">
                            <v-autocomplete v-bind="field" :error-messages="errors" label="Select Students"
                                :items="computedStudents" item-title="student_id" item-value="id"
                                v-model="form.student_ids" multiple chips closable-chips variant="outlined"
                                placeholder="Search and select students" persistent-placeholder></v-autocomplete>
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
</template>

<script setup>
    import { useForm, router } from '@inertiajs/vue3';
    import { computed } from 'vue';
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
        students: {
            type: Object,
            required: true,
        }
    });

    const computedStudents = computed(() => {
        return props.students.map((student) => {
            return {
                id: student.id,
                student_id: `${student.student_id} - ${student.first_name} ${student.last_name}`,
            }
        });
    });


    const schema = yup.object().shape({
        student_ids: yup.array().min(1, "Please select at least one student").required("Student selection is required"),
    });

    const form = useForm({
        student_ids: null
    });

    /**
     * Back to previous page
     */
    const backCallback = () => {
        router.get(route('classes.generations.academics.students.index', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id
        }));
    }

    /**
     * Submit the form
     *
     * @param setErrors
     */
    const submitForm = (setErrors) => {
        form.post(route('classes.generations.academics.students.store', {
            class: props.itClass.id,
            generation: props.generation.data.id,
            academic: props.academic.data.id,
        }), {
            onError: (errors) => {
                setErrors(errors);
            },
            forceFormData: true,
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
