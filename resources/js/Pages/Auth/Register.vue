<template>
    <v-container fluid class="fill-height pa-0 ma-0 bg-surface">
        <v-row no-gutters class="fill-height ma-0">
            <!-- Brand/Logo Side with Gradient Background -->
            <v-col cols="12" md="5"
                class="d-none d-md-flex primary-gradient align-center justify-center position-relative">
                <div class="text-center px-8">
                    <v-img :width="220" :height="220" src="assets/logo.png" alt="Logo" class="mx-auto mb-8"></v-img>
                    <h1 class="text-h3 font-weight-bold text-white mb-4">Student Management System</h1>
                    <p class="text-subtitle-1 text-white">Manage your IT classes and student data efficiently</p>
                </div>
                <div class="position-absolute bottom-0 pa-4 text-white w-100">
                    <p class="text-caption text-center">© 2025 IT Department</p>
                </div>
            </v-col>

            <!-- Registration Form Side -->
            <v-col cols="12" md="7" class="d-flex align-center justify-center">
                <v-card width="100%" elevation="0" class="pa-6 px-md-12 mx-auto overflow-y-auto registration-card">
                    <div class="d-md-none text-center mb-6">
                        <v-img :width="120" :height="120" src="assets/logo.png" alt="Logo" class="mx-auto mb-2"></v-img>
                    </div>

                    <h1 class="text-h4 font-weight-bold text-center mb-2">Create Account</h1>
                    <p class="text-subtitle-1 text-medium-emphasis text-center mb-6">Register to access the student
                        management system</p>

                    <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
                        <!-- Personal Information -->
                        <div class="mb-6">
                            <h2 class="text-subtitle-1 font-weight-bold mb-4 text-primary">Personal Information</h2>

                            <v-row>
                                <v-col cols="12" md="8">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <vee-field name="student_id" v-slot="{ field, errors }">
                                                <v-text-field v-bind="field" v-model="form.student_id"
                                                    label="Student ID" variant="outlined" color="primary"
                                                    prepend-inner-icon="mdi-card-account-details-outline"
                                                    :error-messages="errors" class="mb-3"></v-text-field>
                                            </vee-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <vee-field name="date_of_birth" v-slot="{ field, errors }">
                                                <v-text-field v-bind="field" v-model="form.date_of_birth"
                                                    label="Date of Birth" variant="outlined" color="primary"
                                                    prepend-inner-icon="mdi-calendar" type="date"
                                                    :error-messages="errors" class="mb-3"></v-text-field>
                                            </vee-field>
                                        </v-col>
                                    </v-row>

                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <vee-field name="first_name" v-slot="{ field, errors }">
                                                <v-text-field v-bind="field" v-model="form.first_name"
                                                    label="First Name" variant="outlined" color="primary"
                                                    prepend-inner-icon="mdi-account" :error-messages="errors"
                                                    class="mb-3"></v-text-field>
                                            </vee-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <vee-field name="last_name" v-slot="{ field, errors }">
                                                <v-text-field v-bind="field" v-model="form.last_name" label="Last Name"
                                                    variant="outlined" color="primary" prepend-inner-icon="mdi-account"
                                                    :error-messages="errors" class="mb-3"></v-text-field>
                                            </vee-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="12" md="4" class="d-flex justify-center align-items-start">
                                    <image-uploader v-model="form.image" :placeholder="form.image_url"></image-uploader>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <vee-field name="gender" v-slot="{ field, errors }">
                                        <label class="text-subtitle-2 mb-1 d-block">Gender</label>
                                        <v-radio-group v-bind="field" :error-messages="errors" v-model="form.gender"
                                            inline color="primary" class="mt-0 gender-radio-group">
                                            <v-radio label="Male" value="male" class="mr-6"></v-radio>
                                            <v-radio label="Female" value="female" class="mr-6"></v-radio>
                                            <v-radio label="Other" value="other"></v-radio>
                                        </v-radio-group>
                                    </vee-field>
                                </v-col>
                            </v-row>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-6">
                            <h2 class="text-subtitle-1 font-weight-bold mb-4 text-primary">Contact Information</h2>

                            <v-row>
                                <v-col cols="12" md="6">
                                    <vee-field name="email" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.email" label="Email"
                                            variant="outlined" color="primary" prepend-inner-icon="mdi-email-outline"
                                            :error-messages="errors" class="mb-3"></v-text-field>
                                    </vee-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <vee-field name="phone" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.phone" label="Phone"
                                            variant="outlined" color="primary" prepend-inner-icon="mdi-phone-outline"
                                            :error-messages="errors" class="mb-3"></v-text-field>
                                    </vee-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <vee-field name="address" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.address" label="Address"
                                            variant="outlined" color="primary"
                                            prepend-inner-icon="mdi-map-marker-outline" :error-messages="errors"
                                            class="mb-3"></v-text-field>
                                    </vee-field>
                                </v-col>
                            </v-row>
                        </div>

                        <!-- Account Security -->
                        <div class="mb-6">
                            <h2 class="text-subtitle-1 font-weight-bold mb-4 text-primary">Account Security</h2>

                            <v-row>
                                <v-col cols="12" md="6">
                                    <vee-field name="password" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.password" label="Password"
                                            variant="outlined" color="primary" prepend-inner-icon="mdi-lock-outline"
                                            :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                            :type="showPassword ? 'text' : 'password'"
                                            @click:append-inner="showPassword = !showPassword" :error-messages="errors"
                                            class="mb-3"></v-text-field>
                                    </vee-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <vee-field name="password_confirmation" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.password_confirmation"
                                            label="Confirm Password" variant="outlined" color="primary"
                                            prepend-inner-icon="mdi-lock-check-outline"
                                            :type="showPassword ? 'text' : 'password'" :error-messages="errors"
                                            class="mb-3"></v-text-field>
                                    </vee-field>
                                </v-col>
                            </v-row>
                        </div>

                        <v-divider class="mb-6"></v-divider>

                        <v-row>
                            <v-col cols="12" class="d-flex justify-space-between align-center">
                                <v-btn color="secondary" variant="text" @click="goToLogin" class="text-none">
                                    <v-icon start>mdi-arrow-left</v-icon>
                                    Back to Login
                                </v-btn>

                                <v-btn color="primary" size="large" min-width="150" :loading="form.processing"
                                    :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)"
                                    class="px-6">
                                    <v-icon start>mdi-account-plus</v-icon>
                                    Create Account
                                </v-btn>
                            </v-col>
                        </v-row>
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

    const schema = yup.object().shape({
        student_id: yup.string().required("Student ID is required"),
        first_name: yup.string().required("First name is required").min(2, "First name must be at least 2 characters"),
        last_name: yup.string().required("Last name is required").min(2, "Last name must be at least 2 characters"),
        date_of_birth: yup.date().required("Date of birth is required").typeError("Invalid date format"),
        address: yup.string().required("Address is required").min(5, "Address must be at least 5 characters"),
        email: yup.string().email("Invalid email format").required("Email is required"),
        phone: yup.string().required("Phone is required").min(9, "Phone must be at least 9 characters"),
        password: yup.string().required("Password is required").min(8, "Password must be at least 8 characters"),
        password_confirmation: yup.string()
            .required("Please confirm your password")
            .oneOf([yup.ref('password')], "Passwords must match"),
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

    const submitForm = (setErrors) => {
        form.post(route('register.store'), {
            onError: (errors) => {
                setErrors(errors);
            },
            forceFormData: true,
        });
    };

    const goToLogin = () => {
        router.visit(route('login'), {
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

    .fill-height {
        min-height: 100vh;
    }

    .w-100 {
        width: 100%;
    }

    .profile-uploader {
        width: 100%;
        max-width: 200px;
    }

    /* Make the card scrollable on smaller height screens */
    .registration-card {
        max-height: 90vh;
    }

    /* Custom styles for gender radio buttons */
    .gender-radio-group :deep(.v-selection-control) {
        margin-right: 24px;
    }

    .gender-radio-group :deep(.v-selection-control__wrapper) {
        margin-right: 8px;
    }

    /* Rounded image uploader */
    .rounded-image-container {
        border-radius: 50%;
        overflow: hidden;
        width: 200px;
        height: 200px;
        border: 3px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .rounded-image-container :deep(img) {
        border-radius: 50%;
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .rounded-image-container :deep(.v-btn) {
        border-radius: 50%;
    }

    /* Additional styles to ensure proper image cropping */
    .rounded-image-container :deep(.image-uploader) {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .rounded-image-container :deep(.image-uploader__container) {
        width: 100% !important;
        height: 100% !important;
        border-radius: 50% !important;
        overflow: hidden;
    }

    .rounded-image-container :deep(.image-uploader__preview) {
        width: 100% !important;
        height: 100% !important;
        border-radius: 50% !important;
        overflow: hidden;
    }

    .rounded-image-container :deep(canvas),
    .rounded-image-container :deep(div[role="button"]) {
        width: 100% !important;
        height: 100% !important;
        border-radius: 50% !important;
        overflow: hidden;
    }

    @media (max-width: 960px) {
        .v-card {
            box-shadow: none !important;
        }

        .registration-card {
            max-height: none;
            padding: 16px !important;
        }
    }
</style>
