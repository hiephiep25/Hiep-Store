<template>
    <div class="row wrap justify-center q-mb-md">
        <span class="col-md-2 col-12 q-my-auto" v-if="label">
            <span class="text-red q-pt-md q-mr-sm" v-if="required">*</span>
            {{ label }}
        </span>
        <div class="col-md-8 col-12 col-auto">
            <q-file v-model="modelValue[name]" :label="placeholder" :accept="accept" :max-files="maxFiles"
                :clearable="clearable" outlined dense bottom-slots @clear="modelValue[name] = null"
                @change="handleFileChange">
                <template v-slot:append>
                    <q-icon name="attach_file" />
                </template>
            </q-file>
        </div>
        <div class="col-md-6 col-12 q-auto">
            <p class="text-red custom-error" v-if="errors[name]">{{ errors[name][0] }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
        required: false,
    },
    name: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
    accept: {
        type: String,
        default: ".jpg, .png, .jpeg",
    },
    maxFiles: {
        type: Number,
        default: 1,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    disable: {
        type: Boolean,
        default: false,
    },
    errors: {
        type: Object,
        default: {},
    },
    modelValue: {
        type: Object,
        required: false,
    },
    rules: {
        type: Array,
        default: [],
    },
});

const handleFileChange = (files) => {
    if (files && files.length > 0) {
        const file = files[0];
        modelValue[name] = file;
    }
};
</script>
