<template>
    <v-row dense>
        <v-col :cols="12" :md="7">
            <v-row dense>
                <v-col :cols="12" :md="7" class="mt-4">
                    <v-row dense>
                        <v-col :cols="12" :md="4" class="px-0">
                            <p>{{ student.student_id }}</p>
                        </v-col>
                        <v-col :cols="12" :md="8" class="mt-2">
                            <p>{{ student.gender }}</p>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col :cols="12" :md="12" class="px-0">
                            <p>{{ student.first_name }}</p>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col :cols="12" :md="12">
                            <p>{{ student.last_name }}</p>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col :cols="12" :md="5">
                    <v-img :src="'/' + (student.image.path)"></v-img>
                </v-col>
            </v-row>


            <v-row dense>
                <v-col :cols="12" :md="6">
                    <p>{{ student.date_of_birth }}</p>
                </v-col>
                <v-col :cols="12" :md="6">
                    <p>{{ student.email }}</p>
                </v-col>
            </v-row>

            <v-row dense>
                <v-col :cols="12" :md="6">
                    <p>{{ student.phone }}</p>
                </v-col>
                <v-col :cols="12" :md="6">
                    <p>{{ student.address }}</p>
                </v-col>
            </v-row>

            <v-row dense>
                <v-col :cols="12" :md="12">
                    <v-btn color="blue" class="mt-4 d-inline-flex justify-content-start" @click="backCallback">
                        Back
                    </v-btn>
                </v-col>
            </v-row>
        </v-col>
        <v-col :cols="12" :md="5">
            <v-card height="100%" :elevation="0">
                <v-card-title class="d-flex">
                    Academic Year
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-table>
                        <thead class="bg-blue-grey-lighten-5">
                            <tr>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Room No</th>
                            </tr>
                        </thead>
                        <tbody v-if="student.academics.length > 0">
                            <tr v-for="(academic, index) in student.academics" :key="index">
                                <td>{{academicYears.find(a => a.value === academic.academic_id)?.title}}</td>
                                <td>{{ academic.class }}</td>
                                <td>{{ academic.room_no }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="8" class="text-center">No Data.</td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup>
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        student: Object,
        academicYears: Array,
    });

    /**
     * Back callback
     *
     * @return {void}
     */
    const backCallback = () => {
        router.get(route('students.index'));
    };
</script>
