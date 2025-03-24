<template>
    <Modal v-slot="{ close }">
        <div class="w-full p-6 bg-white rounded-2xl align-center">
            <h1 class="mt-20 mb-4 text-2xl font-semibold text-center text-red-600">Delete Student</h1>
            <p class="mb-6 text-center text-gray-600">
                Are you sure you want to delete this student in class? This action cannot be undone.
            </p>
            <div class="flex items-center justify-between space-x-2">
                <button type="button" @click="close"
                    class="w-full py-2 font-medium text-gray-700 transition bg-gray-300 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <button type="button" @click="submitForm(); close();"
                    class="w-full py-2 font-medium text-red-700 transition bg-red-700 rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
    student: {
        type: Object,
        required: true,
    },
    itClass: {
        type: Object,
        required: true,
    },
    generation: {
        type: Object,
        required: true,
    },
    academic: {
        type: Object,
        required: true,
    },
});

/**
 * Submit callback to delete the student
 *
 * @return void
 */
const submitForm = () => {
    router.delete(route('classes.generations.academics.students.destroy', {
        student: props.student.id,
        class: props.itClass,
        generation: props.generation.data.id,
        academic: props.academic.data.id,
    }));
}
</script>