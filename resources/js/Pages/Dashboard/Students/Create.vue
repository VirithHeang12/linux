<template>
    <Modal>
        <v-row>
            <v-col cols="12">
                <h3>Register Student</h3>
            </v-col>
        </v-row>
        <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }"
            :initial-values="form">
            <v-container>
                <v-row class="pb-2">
                    <v-col cols="12" md="12">
                        <v-row>
                            <v-col cols="12" md="6" class="text-center">
                                <image-uploader v-model="form.image" :placeholder="form.image_url"></image-uploader>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-row>
                                    <v-col cols="12">
                                        <vee-field name="student_id" v-slot="{ field, errors }">
                                            <v-text-field v-bind="field" v-model="form.student_id" label="Student ID"
                                                variant="outlined" density="comfortable"
                                                prepend-inner-icon="mdi-card-account-details-outline"
                                                :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                                hide-details="auto"></v-text-field>
                                        </vee-field>
                                    </v-col>
                                </v-row>
                                <v-row class="mt-2">
                                    <v-col cols="12">
                                        <vee-field name="gender" v-slot="{ field, errors }">
                                            <v-radio-group v-bind="field" v-model="form.gender" inline
                                                :error-messages="errors" density="compact" hide-details="auto"
                                                class="mt-n2">
                                                <label class="mb-1 text-subtitle-2 text-grey-darken-2">Gender</label>
                                                <v-radio label="Male" value="male" color="primary"></v-radio>
                                                <v-radio label="Female" value="female" color="primary"></v-radio>
                                                <v-radio label="Other" value="other" color="primary"></v-radio>
                                            </v-radio-group>
                                        </vee-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <vee-field name="first_name" v-slot="{ field, errors }">
                                            <v-text-field v-bind="field" v-model="form.first_name" label="First Name"
                                                variant="outlined" prepend-inner-icon="mdi-account"
                                                density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                                class="rounded-lg" hide-details="auto"></v-text-field>
                                        </vee-field>
                                    </v-col>
                                    <v-col cols="12" md="12">
                                        <vee-field name="last_name" v-slot="{ field, errors }">
                                            <v-text-field v-bind="field" v-model="form.last_name" label="Last Name"
                                                variant="outlined" prepend-inner-icon="mdi-account"
                                                density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                                class="rounded-lg" hide-details="auto"></v-text-field>
                                        </vee-field>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12" md="6">
                                <vee-field name="date_of_birth" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.date_of_birth" label="Date of Birth"
                                        variant="outlined" type="date" prepend-inner-icon="mdi-calendar"
                                        density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                        class="rounded-lg" hide-details="auto"></v-text-field>
                                </vee-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <vee-field name="phone" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.phone" label="Phone" variant="outlined"
                                        prepend-inner-icon="mdi-phone-outline" density="comfortable"
                                        :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                        hide-details="auto"></v-text-field>
                                </vee-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12" md="12">
                                <vee-field name="email" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.email" label="Email" variant="outlined"
                                        prepend-inner-icon="mdi-email-outline" density="comfortable"
                                        :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                        hide-details="auto"></v-text-field>
                                </vee-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12" md="12">
                                <vee-field name="address" v-slot="{ field, errors }">
                                    <v-textarea v-bind="field" v-model="form.address" label="Address" variant="outlined"
                                        prepend-inner-icon="mdi-map-marker-outline" density="comfortable"
                                        :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                        hide-details="auto"></v-textarea>
                                </vee-field>
                            </v-col>
                        </v-row>

                        <v-row class="mt-3">

                            <v-col cols="12">
                                <v-btn style="background-color: #209ab9"
                                    class="px-6 text-white rounded-lg text-capitalize text-subtitle-1" :disabled="!meta.valid || form.processing
                                        " @click.prevent="submitForm(setErrors)" prepend-icon="mdi-content-save"
                                    elevation="2">
                                    <v-progress-circular v-if="form.processing" indeterminate size="20" width="2"
                                        class="mr-2"></v-progress-circular>
                                    Save
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </vee-form>
    </Modal>
</template>

<script setup>
    import { useForm, usePage } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import { route } from 'ziggy-js';

    const schema = yup.object().shape({
        student_id: yup.string().required("Student ID is required"),
        first_name: yup.string().required("First name is required").min(2, "First name must be at least 2 characters"),
        last_name: yup.string().required("Last name is required").min(2, "Last name must be at least 2 characters"),
        date_of_birth: yup.date().required("Date of birth is required").typeError("Invalid date format"),
        address: yup.string().required("Address is required").min(5, "Address must be at least 5 characters"),
        email: yup.string().email("Invalid email").required("Email is required"),
        phone: yup.string().required("Phone is required").min(9, "Phone must be at least 10 characters"),
    });

    const page = usePage();

    const form = useForm({
        student_id: '',
        first_name: '',
        last_name: '',
        gender: 'male',
        date_of_birth: '',
        address: '',
        email: '',
        phone: '',
        image: null,
        image_url: null,
    });


    /**
     * Submit callback to store student.
     *
     * @param setErrors
     */
    const submitForm = (setErrors) => {
        form.post(route('students.store'), {
            onError: (errors) => {
                setErrors(errors);
            },
            forceFormData: true,
        });
    }
</script>
