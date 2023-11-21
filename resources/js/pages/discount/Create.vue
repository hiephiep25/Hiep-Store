<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Discount's name" :errors="errors" />
                            <Input v-model:model-value="form" name="code" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Code" :errors="errors" />
                            <Input v-model:model-value="form" name="value" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Value" :errors="errors" />
                            <Input v-model:model-value="form" name="description" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Description" :errors="errors" />
                            <Input v-model:model-value="form" name="quantity" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Quantity" :errors="errors" />
                            <Input v-model:model-value="form" name="expiration_date" type="date" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Expiration date" :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn type="submit" color="primary" label="Create" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>

import { reactive, ref } from 'vue';
import { useDiscountStore } from '@/store/discount';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';

const form = reactive({
    name: "",
    code: "",
    value: "",
    description: "",
    quantity: "",
    expiration_date: "",
});
const errors = ref({});
const router = useRouter();
const discountStore = useDiscountStore();
const notify = useNotify();

const create = async () => {
    try {
        await discountStore.create(form);
        errors.value = {};
        notify.success('Added data successfully');
        router.push({ name: 'discount.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};
</script>
