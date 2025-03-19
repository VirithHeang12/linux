<template>
    <div class="w-4/5 mx-auto mt-10">
        <v-card height="100%" :elevation="1" class="px-4">
            <v-row>
                <v-col cols="12">
                    <h1 class="justify-center mt-2 text-2xl font-bold d-flex">Register</h1>
                </v-col>
            </v-row>
            <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                <v-row dense>
                    <v-col :cols="12" :md="7" class="mt-4">
                        <v-col :cols="12" :md="12" class="px-0">
                            <vee-field name="student_id" v-slot="{ field, errors }">
                                <v-text-field v-bind="field" v-model="form.student_id" label="Student ID *"
                                    variant="outlined" :error-messages="errors"></v-text-field>
                            </vee-field>
                        </v-col>
                        <v-col :cols="12" :md="12" class="px-0">
                            <vee-field name="first_name" v-slot="{ field, errors }">
                                <v-text-field v-bind="field" v-model="form.first_name" label="First Name *"
                                    variant="outlined" :error-messages="errors"></v-text-field>
                            </vee-field>
                        </v-col>
                    </v-col>
                    <v-col :cols="12" :md="5">
                        <image-uploader v-model="form.image" :placeholder="form.image_url"></image-uploader>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12" :md="7">
                        <vee-field name="last_name" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.last_name" label="Last Name *" variant="outlined"
                                :error-messages="errors"></v-text-field>
                        </vee-field>
                    </v-col>
                    <v-col :cols="12" :md="5" class="mt-2">
                        <vee-field name="gender" v-slot="{ field, errors }">
                            <v-radio-group v-bind="field" :error-messages="errors" v-model="form.gender" inline>
                                <v-radio label="Male" value="male"></v-radio>
                                <v-radio label="Female" value="female"></v-radio>
                                <v-radio label="Other" value="other"></v-radio>
                            </v-radio-group>
                        </vee-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12" :md="6">
                        <vee-field name="date_of_birth" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.date_of_birth" label="Date of Birth *"
                                variant="outlined" type="date" :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                    <v-col :cols="12" :md="6">
                        <vee-field name="email" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.email" label="Email *" variant="outlined"
                                :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                </v-row>


                <v-row dense>
                    <v-col :cols="12" :md="6">
                        <vee-field name="password" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.password" label="Password *" variant="outlined"
                                :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                    <v-col :cols="12" :md="6">
                        <vee-field name="password_confirmation" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.password_confirmation" label="Confirm Password *"
                                variant="outlined" :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12" :md="6">
                        <vee-field name="phone" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.phone" label="Phone *" variant="outlined"
                                :error-messages="errors">
                            </v-text-field>
                        </vee-field>

                    </v-col>
                    <v-col :cols="12" :md="6">
                        <vee-field name="address" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.address" label="Address" variant="outlined"
                                :error-messages="errors"></v-text-field>
                        </vee-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12">
                        <v-btn color="primary" class="mt-4 d-inline-flex justify-content-start "
                            :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
                            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Submit
                        </v-btn>
                    </v-col>
                </v-row>
            </vee-form>
        </v-card>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
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
    password: '',
    password_confirmation: '',
});

/**
 * Submit callback to store student.
 *
 * @param setErrors
 */
const submitForm = (setErrors) => {
    form.post(route('register.store'), {
        onError: (errors) => {
            setErrors(errors);
        },
        forceFormData: true,
    });
}
</script>

<style>
.im-dialog {
    z-index: 999999;
    border-radius: 10px;
}

.im-close-button {
    margin: 15px;
}

.im-close-button svg path {
    stroke: rgb(114, 114, 114);
    transition: 0.3s;
}

.im-close-button:hover.im-close-button svg path {
    stroke: rgb(56, 56, 56);
}

.im-modal-container {
    scrollbar-width: none !important;
}

.im-modal-positioner {
    padding: 9px;
}

.im-modal-content {
    min-height: 90vh !important;
    border-radius: 10px;
}
</style>
