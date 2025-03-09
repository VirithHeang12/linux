<template>
    <v-container class="justify-center h-screen d-flex align-center ga-0">
        <v-row>
            <v-col :cols="12" :md="6" class="justify-center d-flex">
                <v-img :width="300" :height="300" src="assets/logo.png" alt=""></v-img>
            </v-col>
            <v-col :cols="12" :md="6">
                <div class="justify-center mb-6 d-flex flex-column">
                    <h1 class="text-2xl font-bold text-center text-blue-500 ">LOGIN</h1>
                    <p class="text-center text-gray-400">Enter your details to sign in to your account</p>
                </div>
                <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                    <vee-field name="email" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" :error-messages="errors" v-model="form.email" label="Email"
                            variant="outlined"></v-text-field>
                    </vee-field>
                    <vee-field name="password" v-slot="{ field, errors }">
                        <v-text-field v-bind="field" :error-messages="errors" v-model="form.password" label="Password"
                            type="password" variant="outlined"></v-text-field>

                    </vee-field>
                    <v-btn color="primary" class="mt-4 d-inline-flex justify-content-start w-100"
                        :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
                        <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                            aria-hidden="true"></span>
                        LOGIN
                    </v-btn>
                </vee-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import * as yup from 'yup';
import { route } from 'ziggy-js';
const schema = yup.object().shape({
    email: yup.string().required().email(),
    password: yup.string().required().min(6),
})


const form = useForm({
    email: '',
    password: '',
});

const submitForm = (setErrors) => {
    form.post(route('login.store'), {
        onError: (errors) => {
            setErrors(errors);
        },
    });
}
</script>

<style scoped></style>
