<template>
    <div class="row wrap justify-center q-mb-md">
        <span class="col-md-2 col-12 q-my-auto" v-if="label">
            <span class="text-red q-pt-md q-mr-sm" v-if="required">*</span>
            {{ label }}
        </span>
        <div class="col-md-8 col-12 col-auto">
            <q-select outlined v-model="modelValue[name]" :options="option" emit-value dense map-options
                option-value="label" option-label="label" clearable>
            </q-select>
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
        required: false
    },
    name: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        required: false
    },
    required: {
        type: Boolean,
        default: false
    },
    disable: {
        type: Boolean,
        default: false
    },
    option: {
        type: Object,
        default: []
    },
    errors: {
        type: Object,
        default: {}
    },
    modelValue: {
        type: Object,
        required: false
    },
});
</script>
