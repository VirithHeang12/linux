<template>
    <v-card :flat="flat">
        <v-card-text class="text-center">
            <label :for="id">
                <v-img :src="imagePreview || placeholder" width="200px" height="200px" :aspect-ratio="1" cover
                    class="image-picker text-center" v-if="imagePreview || placeholder" />
                <v-img :src="'/assets/place-holder.png'" width="200px" height="200px" :aspect-ratio="1" cover
                    class="image-picker text-center" v-else />
            </label>
            <v-file-input v-model="image" accept="image/*" style="display: none !important" :id="id" :name="id"
                :multiple="false" @change="handleFileChanged" />
        </v-card-text>
    </v-card>
</template>

<script setup>
    import { ref } from "vue";

    const emit = defineEmits(["update:modelValue"]);

    const props = defineProps({
        modelValue: File,
        placeholder: String,
        id: {
            type: String,
            default: "Image",
        },
        title: {
            type: String,
            default: "Select Image",
        },
        flat: {
            type: Boolean,
            default: true,
        },
    });

    const image = ref();
    const imagePreview = ref(null);

    const handleFileChanged = (e) => {
        image.value = e.target.files;
        emit("update:modelValue", image.value[0]);
        imagePreview.value = URL.createObjectURL(image.value[0]);
    };
</script>

<style scoped>
    .image-picker {
        cursor: pointer;
        border-radius: 9999px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .image-picker:hover {
        opacity: 0.8;
    }
</style>
