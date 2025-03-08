<template>
    <Modal>
        <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
            <vee-field name="student_id" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.student_id" label="Student ID" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="firstname" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.firstname" label="First Name" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="lastname" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.lastname" label="Last Name" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="gender" v-slot="{ field, errors }">
                <v-select v-bind="field" v-model="form.gender" :items="['M', 'F']" label="Select Gender"
                    variant="outlined" :error-messages="errors"></v-select>
            </vee-field>

            <vee-field name="dob" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.dob" label="Date of Birth" variant="outlined" type="date"
                    :error-messages="errors">
                </v-text-field>
            </vee-field>

            <vee-field name="address" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.address" label="Address" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>
            <v-btn color="primary" class="mt-4 d-inline-flex justify-content-start "
                :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
                <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                    aria-hidden="true"></span>
                Submit
            </v-btn>
        </vee-form>
    </Modal>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import * as yup from 'yup';
import { route } from 'ziggy-js';

const schema = yup.object().shape({
    student_id: yup.string().required("Student ID is required"),
    firstname: yup.string().required("First name is required").min(2, "First name must be at least 2 characters"),
    lastname: yup.string().required("Last name is required").min(2, "Last name must be at least 2 characters"),
    gender: yup.string().oneOf(["M", "F"], "Invalid gender").required("Gender is required"),
    dob: yup.date().required("Date of birth is required").typeError("Invalid date format"),
    address: yup.string().required("Address is required").min(5, "Address must be at least 5 characters"),
});

const form = useForm({
    student_id: '',
    firstname: '',
    lastname: '',
    gender: '',
    dob: '',
    address: '',
    email: '',
    phone: '',
});

const submitForm = () => {
    form.post(route('students.store'));
}
</script>
