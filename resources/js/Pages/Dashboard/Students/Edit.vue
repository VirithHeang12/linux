<template>
    <Modal v-slot="{ close }">
        <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }"
            :initial-values="form">
            <vee-field name="student_id" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.student_id" label="Student ID" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="first_name" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.first_name" label="First Name" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="last_name" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.last_name" label="Last Name" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>

            <vee-field name="gender" v-slot="{ field, errors }">
                <v-select v-bind="field" v-model="form.gender" :items="genders" label="Select Gender" variant="outlined"
                    :error-messages="errors"></v-select>
            </vee-field>

            <vee-field name="date_of_birth" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.date_of_birth" label="Date of Birth" variant="outlined"
                    type="date" :error-messages="errors">
                </v-text-field>
            </vee-field>

            <vee-field name="email" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.email" label="Email" variant="outlined"
                    :error-messages="errors">
                </v-text-field>
            </vee-field>

            <vee-field name="phone" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.phone" label="Phone" variant="outlined"
                    :error-messages="errors">
                </v-text-field>
            </vee-field>

            <vee-field name="address" v-slot="{ field, errors }">
                <v-text-field v-bind="field" v-model="form.address" label="Address" variant="outlined"
                    :error-messages="errors"></v-text-field>
            </vee-field>
            <v-btn @click="close" color="primary" class="mt-4 d-inline-flex justify-content-start "
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
    import { defineProps } from 'vue';

    const schema = yup.object().shape({
        student_id: yup.string().required("Student ID is required"),
        first_name: yup.string().required("First name is required").min(2, "First name must be at least 2 characters"),
        last_name: yup.string().required("Last name is required").min(2, "Last name must be at least 2 characters"),
        gender: yup.string().required('Gender is required'),
        date_of_birth: yup.date().required("Date of birth is required").typeError("Invalid date format"),
        address: yup.string().required("Address is required").min(5, "Address must be at least 5 characters"),
        email: yup.string().email("Invalid email").required("Email is required"),
        phone: yup.string().required("Phone is required").min(9, "Phone must be at least 10 characters"),
    });

    const props = defineProps({
        student: {
            type: Object,
            required: true,
        },
        genders: {
            type: Array,
            required: true,
        },
    });

    const form = useForm({
        student_id: props.student.student_id,
        first_name: props.student.first_name,
        last_name: props.student.last_name,
        gender: props.student.gender,
        date_of_birth: props.student.date_of_birth,
        address: props.student.address,
        email: props.student.email,
        phone: props.student.phone,
    });

    const submitForm = () => {
        form.put(route('students.update', props.student.id));
    }
</script>
