<template>
    <div class="q-pa-sm" :class="widthCommon">
        <div class="row">
            <div :class="widthLabel" class="self-center text-black">
                {{ label }}
                <span v-if="required" class="required">*</span>
            </div>
            <div :class="widthInput" class="q-pl-sm self-center">
                <q-select
                    outlined
                    v-model="selectedValue"
                    :options="selectOptions"
                    :placeholder="placeholder"
                    :disable="disable"
                    :dense="true"
                    clearable
                    hide-bottom-space
                    @update:model-value="$emit('updateModel')"
                ></q-select>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    required: {
        type: Boolean,
        default: false,
    },
    modelValue: {
        type: [String, Number],
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    widthCommon: {
        type: String,
        default: "col-12",
    },
    widthLabel: {
        type: String,
        default: "col-3",
    },
    widthInput: {
        type: String,
        default: "col-8",
    },
    disable: {
        type: Boolean,
        default: false,
    },
    selectOptions: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["update:modelValue"]);

const selectedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        return emit("update:modelValue", value);
    },
});
</script>

<style lang="scss" scoped></style>
