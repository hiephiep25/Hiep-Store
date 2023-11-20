<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="update()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Name" :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn type="submit" color="primary" label="Edit" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useCategoryStore } from '@/store/category';
import { useRouter, useRoute } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';

const form = reactive({
    name: "",
});

const { params } = useRoute();
const id = params.id;

const errors = ref({});
const router = useRouter();
const categoryStore = useCategoryStore();
const notify = useNotify();

const getCategory = async () => {
    try {
        const category = await categoryStore.getCategory(id);
        form.name = category.name;
    } catch (error) {
        throw error;
    }
};

async function update() {
    try {
        await categoryStore.updateCategory(id, form);
        errors.value = {};
        notify.success('Edited the data successfully');
        router.push({ name: 'category.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

getCategory();
</script>
