<template>
    <v-container fluid class="fill-height pa-0 ma-0 bg-surface">
        <v-row no-gutters class="fill-height ma-0">
            <!-- Brand/Logo Side with Gradient Background -->
            <v-col cols="12" md="6"
                class="d-none d-md-flex primary-gradient align-center justify-center position-relative">
                <div class="text-center px-8">
                    <v-img :width="240" :height="240" src="assets/logo.png" alt="Logo" class="mx-auto mb-8"></v-img>
                    <h1 class="text-h3 font-weight-bold text-white mb-4">Student Management System</h1>
                    <p class="text-subtitle-1 text-white">Manage your IT classes and student data efficiently</p>
                </div>
                <div class="position-absolute bottom-0 pa-4 text-white w-100">
                    <p class="text-caption text-center">© 2025 IT Department</p>
                </div>
            </v-col>

            <!-- Login Form Side -->
            <v-col cols="12" md="6" class="d-flex align-center justify-center">
                <v-card width="100%" elevation="0" class="pa-8 px-md-16 mx-auto">
                    <div class="d-md-none text-center mb-8">
                        <v-img :width="140" :height="140" src="assets/logo.png" alt="Logo" class="mx-auto mb-2"></v-img>
                    </div>

                    <h1 class="text-h3 font-weight-bold text-center mb-2">Welcome Back</h1>
                    <p class="text-subtitle-1 text-medium-emphasis text-center mb-10">Sign in to access your account</p>

                    <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                        <vee-field name="email" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" :error-messages="errors" v-model="form.email" label="Email"
                                prepend-inner-icon="mdi-email-outline" variant="outlined" color="primary" class="mb-5"
                                autocomplete="email"></v-text-field>
                        </vee-field>

                        <vee-field name="password" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" :error-messages="errors" v-model="form.password"
                                label="Password" prepend-inner-icon="mdi-lock-outline"
                                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                :type="showPassword ? 'text' : 'password'"
                                @click:append-inner="showPassword = !showPassword" variant="outlined" color="primary"
                                class="mb-6" autocomplete="current-password"></v-text-field>
                        </vee-field>

                        <v-btn color="primary" size="x-large" block :loading="form.processing"
                            :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)"
                            class="mb-8 mt-2 py-7 text-h6" elevation="2">
                            SIGN IN
                        </v-btn>

                        <p class="text-center text-body-1 text-medium-emphasis">
                            Don't have an account?
                            <a href="#" @click.prevent="registerCallback"
                                class="text-decoration-none text-primary font-weight-medium">Create account</a>
                        </p>
                    </vee-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
    import { ref } from 'vue';
    import { useForm, router } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import { route } from 'ziggy-js';

    const showPassword = ref(false);
    const rememberMe = ref(false);

    const schema = yup.object().shape({
        email: yup.string().email('Please enter a valid email').required('Email is required'),
        password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submitForm = (setErrors) => {
        form.remember = rememberMe.value;
        form.post(route('login.store'), {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    };

    const registerCallback = () => {
        router.visit(route('register'), {
            method: 'get',
            preserveState: true,
            preserveScroll: true,
        });
    };
</script>

<style scoped>
    .primary-gradient {
        background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
        position: relative;
        overflow: hidden;
    }

    .primary-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .position-relative {
        position: relative;
    }

    .position-absolute {
        position: absolute;
    }

    .bottom-0 {
        bottom: 0;
    }

    .fill-height {
        min-height: 100vh;
        height: 100%;
    }

    .w-100 {
        width: 100%;
    }

    @media (max-width: 960px) {
        .v-card {
            box-shadow: none !important;
            padding: 32px 16px !important;
        }
    }

    /* Make sure the form properly stretches on larger screens */
    @media (min-width: 1200px) {
        .pa-8.px-md-16 {
            padding-left: 64px !important;
            padding-right: 64px !important;
        }
    }

    @media (min-height: 800px) {
        .v-btn.py-7 {
            padding-top: 16px !important;
            padding-bottom: 16px !important;
        }
    }
</style>
