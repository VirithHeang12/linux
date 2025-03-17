<template>
    <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }"
        :initial-values="form">
        <v-row dense>
            <v-col :cols="12" :md="7">
                <v-row dense>
                    <v-col :cols="12" :md="7" class="mt-4">
                        <v-row dense>
                            <v-col :cols="12" :md="4" class="px-0">
                                <vee-field name="student_id" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.student_id" label="Student ID *"
                                        variant="outlined" :error-messages="errors"></v-text-field>
                                </vee-field>
                            </v-col>
                            <v-col :cols="12" :md="8" class="mt-2">
                                <vee-field name="gender" v-slot="{ field, errors }">
                                    <v-radio-group v-bind="field" :error-messages="errors" v-model="form.gender" inline>
                                        <v-radio label="Male" value="male"></v-radio>
                                        <v-radio label="Female" value="female"></v-radio>
                                        <v-radio label="Other" value="other"></v-radio>
                                    </v-radio-group>
                                </vee-field>
                            </v-col>
                        </v-row>
                        <v-row dense>
                            <v-col :cols="12" :md="12" class="px-0">
                                <vee-field name="first_name" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.first_name" label="First Name *"
                                        variant="outlined" :error-messages="errors"></v-text-field>
                                </vee-field>
                            </v-col>
                        </v-row>
                        <v-row dense>
                            <v-col :cols="12" :md="12">
                                <vee-field name="last_name" v-slot="{ field, errors }">
                                    <v-text-field v-bind="field" v-model="form.last_name" label="Last Name *"
                                        variant="outlined" :error-messages="errors"></v-text-field>
                                </vee-field>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col :cols="12" :md="5">
                        <image-uploader v-model="form.image" :placeholder="form.image_url"></image-uploader>
                    </v-col>
                </v-row>


                <v-row dense>
                    <v-col :cols="12" :md="6">
                        <vee-field name="date_of_birth" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.date_of_birth" label="Date of Birth *"
                                variant="outlined" type="date" :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                    <v-col :cols="12" :md="6">
                        <vee-field name="email" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.email" label="Email *" variant="outlined"
                                :error-messages="errors">
                            </v-text-field>
                        </vee-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12" :md="6">
                        <vee-field name="phone" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.phone" label="Phone *" variant="outlined"
                                :error-messages="errors">
                            </v-text-field>
                        </vee-field>

                    </v-col>
                    <v-col :cols="12" :md="6">
                        <vee-field name="address" v-slot="{ field, errors }">
                            <v-text-field v-bind="field" v-model="form.address" label="Address" variant="outlined"
                                :error-messages="errors"></v-text-field>
                        </vee-field>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col :cols="12" :md="12">
                        <v-btn color="blue" class="mt-4 d-inline-flex justify-content-start" @click="backCallback">
                            Back
                        </v-btn>
                        <v-btn color="green" class="ml-4 mt-4 d-inline-flex justify-content-start"
                            :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
                            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                                aria-hidden="true"></span>
                            Submit
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <v-col :cols="12" :md="5">
                <v-card height="100%" :elevation="0">
                    <v-card-title class="d-flex">
                        Academic Year
                        <v-spacer></v-spacer>
                        <v-btn @click="addAcademic()">
                            <v-icon>mdi-plus-circle</v-icon>
                            Add
                        </v-btn>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-table>
                            <thead class="bg-blue-grey-lighten-5">
                                <tr>
                                    <th>Date</th>
                                    <th>Class</th>
                                    <th>Room No</th>
                                    <th style="width: 100px" class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody v-if="form.academics.length > 0">
                                <tr v-for="(academic, index) in form.academics" :key="index">
                                    <td>{{academicYears.find(a => a.value === academic.academic_id)?.title}}</td>
                                    <td>{{ academic.class }}</td>
                                    <td>{{ academic.room_no }}</td>

                                    <td class="text-right">
                                        <v-item-group class="d-flex ga-1">
                                            <v-btn icon="mdi-pencil-outline" color="warning" density="comfortable"
                                                @click="editAcademic(index)"></v-btn>
                                            <v-btn icon="mdi-delete-outline" color="red" density="comfortable"
                                                @click="showDeleteAcademic(index)"></v-btn>
                                        </v-item-group>
                                    </td>
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

                <v-dialog v-model="addOrEditDialog" max-width="900px" persistent>
                    <v-card>
                        <v-card-title class="d-flex align-center">
                            <span class="headline">Add Academic Year</span>
                            <v-spacer></v-spacer>

                            <v-btn icon color="primary" size="small" @click="addOrEditDialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-row dense>
                                <v-col :cols="12" :md="12">
                                    <v-autocomplete v-model="selectedAcademic.academic_id" label="Academic Year"
                                        variant="outlined" :items="academicYears" item-title="title" item-value="value"
                                        clearable></v-autocomplete>
                                </v-col>
                                <v-col :cols="12" :md="12">
                                    <v-autocomplete v-model="selectedAcademic.class" label="Class" variant="outlined"
                                        :items="classes" item-title="title" item-value="value"
                                        clearable></v-autocomplete>
                                </v-col>
                                <v-col :cols="12" :md="12">
                                    <v-autocomplete v-model="selectedAcademic.room_no" label="Room No"
                                        variant="outlined" :items="rooms" item-title="title" item-value="value"
                                        clearable></v-autocomplete>
                                </v-col>

                            </v-row>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-text class="text-center">
                            <v-btn color="primary" width="150px" @click="saveAcademic()"
                                :disabled="(selectedAcademic.academic_id == null) || (selectedAcademic.class == null) || (selectedAcademic.room_no == null)">
                                <v-icon left>{{ 'mdi-content-save' }}</v-icon>
                                Save
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="deleteDialog" max-width="900px" persistent>
                    <v-card>
                        <v-card-title class="d-flex align-center">
                            <span class="headline">Delete Academic Year</span>
                            <v-spacer></v-spacer>

                            <v-btn icon color="primary" size="small" @click="deleteDialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text class="text-center" style="font-weight: 700; font-size: 20px;">
                            {{academicYears.find(a => a.value === selectedAcademic.academic_id)?.title}} {{
                                selectedAcademic.class }} {{ selectedAcademic.room_no
                            }}
                        </v-card-text>

                        <v-card-text class="text-center">
                            <v-btn color="red" width="150px" @click="deleteAcademic()">
                                <v-icon left>{{ 'mdi-content-save' }}</v-icon>
                                Save
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-dialog>
            </v-col>
        </v-row>
    </vee-form>
</template>

<script setup>
    import { router, useForm, usePage } from '@inertiajs/vue3';
    import * as yup from 'yup';
    import { route } from 'ziggy-js';
    import { defineProps, ref, watch } from 'vue';
    import { toast } from 'vue3-toastify';

    const props = defineProps({
        student: Object,
        academicYears: Array,
        rooms: Array,
        classes: Array,
    });

    const schema = yup.object().shape({
        student_id: yup.string().required("Student ID is required"),
        first_name: yup.string().required("First name is required").min(2, "First name must be at least 2 characters"),
        last_name: yup.string().required("Last name is required").min(2, "Last name must be at least 2 characters"),
        date_of_birth: yup.date().required("Date of birth is required").typeError("Invalid date format"),
        address: yup.string().required("Address is required").min(5, "Address must be at least 5 characters"),
        email: yup.string().email("Invalid email").required("Email is required"),
        phone: yup.string().required("Phone is required").min(9, "Phone must be at least 10 characters"),
    });

    const form = useForm({
        student_id: props.student.data.student_id,
        first_name: props.student.data.first_name,
        last_name: props.student.data.last_name,
        gender: props.student.data.gender,
        date_of_birth: props.student.data.date_of_birth,
        address: props.student.data.address,
        email: props.student.data.email,
        phone: props.student.data.phone,
        image: null,
        image_url: props.student.data.image?.path,
        academics: props.student.data.academics ?? [],
    });

    const deleteDialog = ref(false);
    const addOrEditDialog = ref(false);
    const selectedAcademic = ref(null);

    /**
      * Add academic
      *
      * @return {void}
      */
    const addAcademic = () => {
        selectedAcademic.value = {
            academic_id: null,
            class: null,
            room_no: null,
        };
        addOrEditDialog.value = true;
    };

    /**
     * Edit academic
     *
     * @param {Number} index
     * @return {void}
     */
    const editAcademic = (index) => {
        selectedAcademic.value = form.academics[index];
        addOrEditDialog.value = true;
    };

    /**
     * Delete academic
     *
     * @param {Number} index
     *
     * @return {void}
     */
    const showDeleteAcademic = (index) => {
        selectedAcademic.value = form.academics[index];
        deleteDialog.value = true;
    };

    /**
     * Delete academic
     *
     * @return {void}
     */
    const deleteAcademic = () => {
        const existingAcademic = form.academics.find((academic) => selectedAcademic.value.academic_id === academic.academic_id);
        if (existingAcademic) {
            form.academics.splice(form.academics.indexOf(existingAcademic), 1);
        }
        deleteDialog.value = false;
        selectedAcademic.value = {
            academic_id: null,
            class: null,
            room_no: null,
        };
    };

    /**
     * Add or edit academic
     *
     * @return {void}
     */
    const saveAcademic = () => {
        const existingAcademic = form.academics.find((academic) => selectedAcademic.value.academic_id === academic.academic_id);

        const newAcademic = {
            ...selectedAcademic.value,
        };

        if (existingAcademic) {
            form.academics.splice(form.academics.indexOf(existingAcademic), 1, newAcademic);
        } else {
            form.academics.push(newAcademic);
        }

        addOrEditDialog.value = false;
        selectedAcademic.value = {
            academic_id: null,
            class: null,
            room_no: null,
        };
    };

    /**
     * Back callback
     *
     * @return {void}
     */
    const backCallback = () => {
        router.get(route('students.index'));
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
        })).post(
            route("students.update", {
                student: props.student.data.id,
            }),
            {
                onError: (errors) => {
                    setErrors(errors);
                },
            }
        );
    }

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

<style>
    .im-dialog {
        z-index: 999999;
        border-radius: 10px;
    }

    .im-close-button {
        margin: 15px;
    }

    .im-close-button svg path {
        stroke: rgb(114, 114, 114);
        transition: 0.3s;
    }

    .im-close-button:hover.im-close-button svg path {
        stroke: rgb(56, 56, 56);
    }

    .im-modal-container {
        scrollbar-width: none !important;
    }

    .im-modal-positioner {
        padding: 9px;
    }

    .im-modal-content {
        min-height: 90vh !important;
        border-radius: 10px;
    }
</style>
