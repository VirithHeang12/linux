<template>
    <vee-form :validation-schema="schema" @submit.prevent="submitForm" v-slot="{ meta, setErrors }">
        <vee-field name="email" v-slot="{ field, errors }">
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" id="password" class="form-control" v-bind="field" v-model="form.name"
                    :aria-describedby="'nameError'" />
                <span v-if="errors.length" id="nameError" class="text-danger">{{ errors[0] }}</span>
            </div>
        </vee-field>
        <v-btn @click="close" color="primary" class="mt-4 d-inline-flex justify-content-start "
            :disabled="!meta.valid || form.processing" @click.prevent="submitForm(setErrors)">
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2" role="status"
                aria-hidden="true"></span>
            {{ __('Submit') }}
        </v-btn>
    </vee-form>
</template>

<script setup>
    import { useForm } from 'vee-validate';


    const form = useForm({
        name: '',
    });

</script>
