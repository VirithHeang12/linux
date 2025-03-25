<template>
    <v-container>
        <v-card>
            <v-card-item class="profile-header">
                <v-card-title class="text-h4 text-white font-weight-medium">Student Profile</v-card-title>
            </v-card-item>

            <vee-form
                :initial-values="form">
                <v-container>
                    <v-row class="pb-2">
                        <v-col cols="12" md="7">
                            <v-row>
                                <v-col cols="12" md="4" class="text-center">
                                    <div class="avatar-wrapper">
                                        <v-avatar size="150" class="mt-n12 mb-3 profile-avatar">
                                            <v-img v-if="form.image_url" :src="form.image_url" cover></v-img>
                                            <v-icon v-else size="72" color="grey-lighten-1">mdi-account</v-icon>
                                        </v-avatar>
                                        <div class="upload-overlay" @click="triggerImageUpload">
                                            <v-icon color="white">mdi-camera</v-icon>
                                            <span class="ml-1 text-white text-caption">Upload</span>
                                            <input type="file" ref="fileInput" class="d-none" @change="onFileChange"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="12" md="8">
                                    <v-row>
                                        <v-col cols="12">
                                                <v-text-field v-bind="field" v-model="form.student_id"
                                                    label="Student ID" variant="outlined" density="comfortable"
                                                    prepend-inner-icon="mdi-card-account-details-outline"
                                                    :error-messages="errors" bg-color="grey-lighten-4"
                                                    class="rounded-lg" hide-details="auto" readonly></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-2">
                                    <v-col cols="12">
                                        <v-radio-group v-bind="field" v-model="form.gender" inline
                                            :error-messages="errors" density="compact" hide-details="auto"
                                            class="mt-n2" disabled>
                                            <label class="text-subtitle-2 text-grey-darken-2 mb-1">Gender</label>
                                            <v-radio label="Male" value="male" color="primary"></v-radio>
                                            <v-radio label="Female" value="female" color="primary"></v-radio>
                                            <v-radio label="Other" value="other" color="primary"></v-radio>
                                        </v-radio-group>
                                    </v-col>
                                </v-row>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="6">
                                        <v-text-field v-bind="field" v-model="form.first_name" label="First Name"
                                            variant="outlined" prepend-inner-icon="mdi-account" density="comfortable"
                                            :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                            hide-details="auto" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                        <v-text-field v-bind="field" v-model="form.last_name" label="Last Name"
                                            variant="outlined" prepend-inner-icon="mdi-account" density="comfortable"
                                            :error-messages="errors" bg-color="grey-lighten-4" class="rounded-lg"
                                            hide-details="auto" readonly></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="6">
                                        <v-text-field v-bind="field" v-model="form.date_of_birth" label="Date of Birth"
                                            variant="outlined" type="date" prepend-inner-icon="mdi-calendar"
                                            density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                            class="rounded-lg" hide-details="auto" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                        <v-text-field v-bind="field" v-model="form.phone" label="Phone"
                                            variant="outlined" prepend-inner-icon="mdi-phone-outline"
                                            density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                            class="rounded-lg" hide-details="auto" readonly></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" md="12">
                                        <v-textarea v-bind="field" v-model="form.address" label="Address"
                                            variant="outlined" prepend-inner-icon="mdi-map-marker-outline"
                                            density="comfortable" :error-messages="errors" bg-color="grey-lighten-4"
                                            class="rounded-lg" hide-details="auto" readonly></v-textarea>
                                </v-col>
                            </v-row>

             
                        </v-col>

                        <v-col cols="12" md="5">
                            <v-card class="rounded-lg" elevation="0" border>
                                <v-card-title class="py-3" style="background-color: rgba(38, 164, 197, 0.1);">
                                    <v-icon class="mr-2">mdi-school-outline</v-icon>
                                    Academic History
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-table class="rounded-lg">
                                        <thead>
                                            <tr class="bg-grey-lighten-5">
                                                <th class="font-weight-medium">Year</th>
                                                <th class="font-weight-medium">Start Date</th>
                                                <th class="font-weight-medium">End Date</th>
                                                <th class="font-weight-medium">Class</th>
                                                <th class="font-weight-medium">Room No</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="student.data && student.data.academics.length > 0">
                                            <tr v-for="(academic, index) in student.data.academics" :key="index">
                                                <td>{{ academic.year }}</td>
                                                <td>{{ academic.start_date }}</td>
                                                <td>{{ academic.end_date }}</td>
                                                <td>{{ academic.class }}</td>
                                                <td>{{ academic.room_no }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-grey-darken-1">
                                                    <v-icon class="mb-2" size="large">mdi-information-outline</v-icon>
                                                    <div>No academic data available.</div>
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
import { useForm, usePage } from '@inertiajs/vue3';
import * as yup from 'yup';
import { route } from 'ziggy-js';
import { defineProps, watch, ref as vueRef } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    student: Object,
});



const fileInput = vueRef(null);

const form = useForm({
    student_id: props.student.student_id,
    first_name: props.student.first_name,
    last_name: props.student.last_name,
    gender: props.student.gender,
    date_of_birth: props.student.date_of_birth,
    address: props.student.address,
    phone: props.student.phone,
    image: null,
    image_url: props.student.data?.image?.path || null,
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
}

const page = usePage();

/**
 * Watch for flash messages
 *
 * @return void
 */
watch(() => page.props.flash, (flash) => {
    const success = page.props.flash.success;
    const error = page.props.flash.error;

    if (success) {
        notify(success);
    } else if (error) {
        notify(error);
    }
}, {
    deep: true,
});
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
