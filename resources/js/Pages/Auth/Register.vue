<template>
    <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
        <vee-field name="name" v-slot="{ field, errors }">
            <v-text-field v-bind="field" :error-messages="errors" v-model="form.name" label="Name"
                variant="outlined"></v-text-field>
        </vee-field>
        <vee-field name="email" v-slot="{ field, errors }">
            <v-text-field v-bind="field" :error-messages="errors" v-model="form.email" label="Email"
                variant="outlined"></v-text-field>
        </vee-field>
        <vee-field name="password" v-slot="{ field, errors }">
            <v-text-field v-bind="field" :error-messages="errors" v-model="form.password" label="Password"
                variant="outlined"></v-text-field>
        </vee-field>
        <vee-field name="password_confirmation " v-slot="{ field, errors }">
            <v-text-field v-bind="field" :error-messages="errors" v-model="form.password_confirmation"
                label="Password Confirmation" variant="outlined"></v-text-field>
        </vee-field>
        <v-btn color="primary" class="mt-4 d-inline-flex justify-content-start "
            :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                aria-hidden="true"></span>
            Submit
        </v-btn>
    </vee-form>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import { route } from 'ziggy-js';

    const schema = yup.object().shape({
        name: yup.string().required(),
        email: yup.string().required().email(),
        password: yup.string().required().min(6),
        // password_confirmation: yup.string()
        //     .oneOf([yup.ref('password'), null], 'Passwords must match')
        //     .required('Password confirmation is required')
    })

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submitForm = () => {
        form.post(route('register.store'));
    }
</script>
