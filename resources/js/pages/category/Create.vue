<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Category's name" :errors="errors" />
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
import { useCategoryStore } from '@/store/category';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';

const form = reactive({
    name: "",
});
const errors = ref({});
const router = useRouter();
const categoryStore = useCategoryStore();
const notify = useNotify();

const create = async () => {
    try {
        await categoryStore.create(form);
        errors.value = {};
        notify.success('Added data successfully');
        router.push({ name: 'category.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};
</script>
