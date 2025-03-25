<template>
    <v-container>
        <v-card>
            <v-card-item class="profile-header">
                <v-card-title class="text-white text-h4 font-weight-medium">Student Profile</v-card-title>
            </v-card-item>

            <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }"
                :initial-values="form">
                <v-container>
                    <v-row class="pb-2">
                        <v-col cols="12" md="6">
                            <v-row>
                                <v-col cols="12" md="4" class="text-center">
                                    <div class="avatar-wrapper">
                                        <v-avatar size="150" class="mb-3 mt-n12 profile-avatar">
                                            <v-img v-if="form.image_url" :src="form.image_url" cover></v-img>
                                            <v-icon v-else size="72" color="grey-lighten-1">mdi-account</v-icon>
                                        </v-avatar>
                                        <div class="upload-overlay" @click="triggerImageUpload">
                                            <v-icon color="white">mdi-camera</v-icon>
                                            <span class="ml-1 text-white text-caption">Upload</span>
                                            <input type="file" ref="fileInput" class="d-none" @change="onFileChange"
                                                accept="image/*" />
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="12" md="8">
                                    <v-row>
                                        <v-col cols="12">
                                            <vee-field name="student_id" v-slot="{ field, errors }">
                                                <v-text-field v-bind="field" v-model="form.student_id"
                                                    label="Student ID" variant="outlined" density="comfortable"
                                                    prepend-inner-icon="mdi-card-account-details-outline"
                                                    :error-messages="errors" bg-color="grey-lighten-4"
                                                    class="rounded-lg" hide-details="auto"></v-text-field>
                                            </vee-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-2">
                                        <v-col cols="12">
                                            <vee-field name="gender" v-slot="{ field, errors }">
                                                <v-radio-group v-bind="field" v-model="form.gender" inline
                                                    :error-messages="errors" density="compact" hide-details="auto"
                                                    class="mt-n2">
                                                    <label
                                                        class="mb-1 text-subtitle-2 text-grey-darken-2">Gender</label>
                                                    <v-radio label="Male" value="male" color="primary"></v-radio>
                                                    <v-radio label="Female" value="female" color="primary"></v-radio>
                                                    <v-radio label="Other" value="other" color="primary"></v-radio>
                                                </v-radio-group>
                                            </vee-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="6">
                                    <vee-field name="first_name" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.first_name" label="First Name"
                                            variant="outlined" prepend-inner-icon="mdi-account" density="comfortable"
                                            :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                            hide-details="auto"></v-text-field>
                                    </vee-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <vee-field name="last_name" v-slot="{ field, errors }">
                                        <v-text-field v-bind="field" v-model="form.last_name" label="Last Name"
                                            variant="outlined" prepend-inner-icon="mdi-account" density="comfortable"
                                            :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                            hide-details="auto"></v-text-field>
                                    </vee-field>
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
                                        <v-text-field v-bind="field" v-model="form.phone" label="Phone"
                                            variant="outlined" prepend-inner-icon="mdi-phone-outline"
                                            density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                            class="rounded-lg" hide-details="auto"></v-text-field>
                                    </vee-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="12">
                                    <vee-field name="address" v-slot="{ field, errors }">
                                        <v-textarea v-bind="field" v-model="form.address" label="Address"
                                            variant="outlined" prepend-inner-icon="mdi-map-marker-outline"
                                            density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                            class="rounded-lg" hide-details="auto"></v-textarea>
                                    </vee-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-card>
                                        <v-card-title class="ml-2">Change Password</v-card-title>
                                        <vee-field name="current_password" v-slot="{ field, errors }">
                                            <v-text-field type="password" v-bind="field" v-model="form.current_password"
                                                label="Current Password" variant="outlined"
                                                prepend-inner-icon="mdi-account" density="comfortable"
                                                :error-messages="errors" bg-color="grey-lighten-4"
                                                class="m-4 rounded-lg" hide-details="auto"></v-text-field>
                                        </vee-field>
                                        <vee-field name="password" v-slot="{ field, errors }">
                                            <v-text-field type="password" v-bind="field" v-model="form.password"
                                                label="New Password" variant="outlined" prepend-inner-icon="mdi-account"
                                                density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                                class="m-4 rounded-lg" hide-details="auto"></v-text-field>
                                        </vee-field>
                                        <vee-field name="password_confirmation" v-slot="{ field, errors }">
                                            <v-text-field type="password" v-bind="field" v-model="form.password_confirmation
                                                " label="Confirm Password" variant="outlined"
                                                prepend-inner-icon="mdi-account" density="comfortable"
                                                :error-messages="errors" bg-color="grey-lighten-4"
                                                class="m-4 rounded-lg" hide-details="auto"></v-text-field>
                                        </vee-field>
                                    </v-card>
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
                                        Save Profile
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-card class="rounded-lg" elevation="0" border>
                                <v-card-title class="py-3" style="
                                        background-color: rgba(
                                            38,
                                            164,
                                            197,
                                            0.1
                                        );
                                    ">
                                    <v-icon class="mr-2">mdi-school-outline</v-icon>
                                    Academic History
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-table class="rounded-lg">
                                        <thead>
                                            <tr class="bg-grey-lighten-5">
                                                <th class="font-weight-medium">
                                                    Year
                                                </th>
                                                <th class="font-weight-medium">
                                                    Start Date
                                                </th>
                                                <th class="font-weight-medium">
                                                    End Date
                                                </th>
                                                <th class="font-weight-medium">
                                                    Class
                                                </th>
                                                <th class="font-weight-medium">
                                                    Room No
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="
                                            student.data.academics &&
                                            student.data.academics.length >
                                            0
                                        ">
                                            <tr v-for="(
academic, index
                                                ) in student.data.academics" :key="index">
                                                <td>{{ academic.year }}</td>
                                                <td>
                                                    {{ academic.start_date }}
                                                </td>
                                                <td>{{ academic.end_date }}</td>
                                                <td>{{ academic.class }}</td>
                                                <td>{{ academic.room_no }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5" class="py-4 text-center text-grey-darken-1">
                                                    <v-icon class="mb-2" size="large">mdi-information-outline</v-icon>
                                                    <div>
                                                        No academic data
                                                        available.
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </vee-form>
        </v-card>
    </v-container>
</template>

<script setup>
    import { useForm, usePage } from "@inertiajs/vue3";
    import * as yup from "yup";
    import { route } from "ziggy-js";
    import { defineProps, watch, ref as vueRef } from "vue";
    import { toast } from "vue3-toastify";

    const props = defineProps({
        student: Object,
    });

    const schema = yup.object().shape({
        student_id: yup.string().required("Student ID is required"),
        first_name: yup
            .string()
            .required("First name is required")
            .min(2, "First name must be at least 2 characters"),
        last_name: yup
            .string()
            .required("Last name is required")
            .min(2, "Last name must be at least 2 characters"),
        date_of_birth: yup
            .date()
            .required("Date of birth is required")
            .typeError("Invalid date format"),
        address: yup
            .string()
            .required("Address is required")
            .min(5, "Address must be at least 5 characters"),
        phone: yup
            .string()
            .required("Phone is required")
            .min(9, "Phone must be at least 10 characters"),
        current_password: yup
            .string()
            .nullable()
            .test(
                'min-length',
                'Password must be at least 8 characters',
                value => !value || value.length >= 8
            )
            .notRequired(), // Allows it to be optional
        password: yup
            .string()
            .nullable()
            .test(
                'min-length',
                'Password must be at least 8 characters',
                value => !value || value.length >= 8
            )
            .notRequired(), // Allows it to be optional
        password_confirmation: yup
            .string()
            .nullable()
            .notRequired()
            .oneOf([yup.ref("password"), null], "Passwords must match")
    });

    const fileInput = vueRef(null);

    const form = useForm({
        student_id: props.student.data.student_id,
        first_name: props.student.data.first_name,
        last_name: props.student.data.last_name,
        gender: props.student.data.gender,
        date_of_birth: props.student.data.date_of_birth,
        address: props.student.data.address,
        phone: props.student.data.phone,
        image: null,
        image_url: props.student.data.image?.path ?? null,
        current_password: "",
        password: "",
        password_confirmation: "",
    });

    /**
     * Trigger file input click
     */
    const triggerImageUpload = () => {
        fileInput.value.click();
    };

    /**
     * Handle file change
     *
     * @param {Event} event
     */
    const onFileChange = (event) => {
        const file = event.target.files[0];
        if (file) {
            form.image = file;

            // Create a preview
            const reader = new FileReader();
            reader.onload = (e) => {
                form.image_url = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    };

    /**
     * Submit callback to update student.
     *
     * @param setErrors
     */
    const submitForm = (setErrors) => {
        form.method = "PUT";
        form.transform((data) => ({
            ...data,
            _method: "PUT",
        })).post(route("students.profile.update"), {
            onError: (errors) => {
                setErrors(errors);
            },
        });
    };

    /**
     * Notify the user
     *
     * @param {string} message
     *
     * @return void
     */
    const notify = (message) => {
        toast(message, {
            autoClose: 1500,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
    };

    const page = usePage();

    /**
     * Watch for flash messages
     *
     * @return void
     */
    watch(
        () => page.props.flash,
        (flash) => {
            const success = page.props.flash.success;
            const error = page.props.flash.error;

            if (success) {
                notify(success);
            } else if (error) {
                notify(error);
            }
        },
        {
            deep: true,
        }
    );
</script>

<style scoped>
    .student-profile-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .profile-card {
        position: relative;
        overflow: visible;
        border-radius: 24px;
    }

    .profile-header {
        background: linear-gradient(to right, #26a4c5, #0e64b4);
        padding-bottom: 2rem;
        border-radius: 24px 24px 0 0;
    }

    .profile-avatar {
        border: 4px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f5f5f5;
        position: relative;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .upload-overlay {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 40px;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        opacity: 1;
        z-index: 1;
        border-radius: 0 0 75px 75px;
    }

    /* Rounded corners for form fields */
    :deep(.v-field__outline__start) {
        border-radius: 12px 0 0 12px !important;
    }

    :deep(.v-field__outline__end) {
        border-radius: 0 12px 12px 0 !important;
    }
</style>
