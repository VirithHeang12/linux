<template>
    <v-row dense>
        <v-col :cols="12" :md="7">
            <v-card height="100%" :elevation="1">
                <v-main class="items-center justify-center d-flex flex-column">
                    <v-avatar size="200" class="border border-gray-300">
                        <v-img :src="props.student.data.image?.path" alt="Student Image"></v-img>
                    </v-avatar>
                    <h1 class="mt-3 text-3xl font-bold text-gray-800">
                        {{ props.student.data.first_name }} {{ props.student.data.last_name }}
                    </h1>
                </v-main>

                <v-divider></v-divider>

                <v-list class="w-full">
                    <v-container class="justify-center py-4 d-flex align-center">
                        <v-row dense>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg">
                                    <v-list-item-title><strong>ID:</strong> {{ props.student.data.id
                                    }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg ">
                                    <v-list-item-title><strong>Gender:</strong> {{ props.student.data.gender
                                        }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg ">
                                    <v-list-item-title><strong>Date of Birth:</strong> {{
                                        props.student.data.date_of_birth
                                        }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg">
                                    <v-list-item-title><strong>Address:</strong> {{ props.student.data.address
                                        }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg ">
                                    <v-list-item-title><strong>Phone:</strong> {{ props.student.data.phone
                                    }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                            <v-col :cols="12" :md="6">
                                <v-list-item class="p-4 mb-4 text-lg ">
                                    <v-list-item-title><strong>Email:</strong> {{ props.student.data.email
                                        }}</v-list-item-title>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-list>
            </v-card>
        </v-col>
        <v-col :cols="12" :md="5">
            <v-card height="100%" :elevation="1">
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
                        <tbody v-if="props.student.data.academics && props.student.data.academics.length > 0">
                            <tr v-for="(academic, index) in props.student.data.academics" :key="index">
                                <td>{{academicYears.find(a => a.value === academic.academic_id)?.title}}</td>
                                <td>{{ academic.class }}</td>
                                <td>{{ academic.room_no }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="3" class="text-center">No Data.</td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup>

const props = defineProps({
    student: Object,
    academicYears: Array,
    rooms: Array,
    classes: Array,
});

</script>