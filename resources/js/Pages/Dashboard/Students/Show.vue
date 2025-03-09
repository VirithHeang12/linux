<template>
    <Modal>
        <v-row justify="center">
            <v-col cols="12">
                <v-card class="w-100">
                    <v-card-title>
                        <span class="headline">Student Details</span>
                    </v-card-title>
                    <v-card-subtitle>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <strong>Student ID:</strong>
                                <p>{{ student.student_id }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>First Name:</strong>
                                <p>{{ student.first_name }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Last Name:</strong>
                                <p>{{ student.last_name }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Gender:</strong>
                                <p>{{ student.gender }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Date of Birth:</strong>
                                <p>{{ student.date_of_birth }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Address:</strong>
                                <p>{{ student.address }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Email:</strong>
                                <p>{{ student.email }}</p>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <strong>Phone:</strong>
                                <p>{{ student.phone }}</p>
                            </v-col>
                        </v-row>
                    </v-card-subtitle>
                </v-card>
            </v-col>
        </v-row>
    </Modal>
</template>


<script setup>

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
        required: true
    }
})
</script>
