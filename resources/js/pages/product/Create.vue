<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()" enctype="multipart/form-data">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Product's name" :errors="errors" />
                            <Input v-model:model-value="form" name="code" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Code" :errors="errors" />
                            <Input v-model:model-value="form" name="brand" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Brand" :errors="errors" />
                            <SelectBox v-model:model-value="form" name="category" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Category" :option="categoryOptions" :errors="errors" />
                            <Input v-model:model-value="form" name="description" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Description" :errors="errors" />
                            <Input v-model:model-value="form" name="qty" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Qty" :errors="errors" />
                            <Input v-model:model-value="form" name="price_per_qty" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Price" :errors="errors" />
                            <Input v-model:model-value="form" name="manufacture_day" type="date"
                                width-common="col-8 q-ml-lg" width-label="col-2" label="Manufacture day" :errors="errors" />
                            <Input v-model:model-value="form" name="expiry_day" type="date" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Expiry day" :errors="errors" />
                            <FileInput v-model:model-value="form" name="image" label="Image" :errors="errors" />
                            <div class="row justify-center" v-if="form.image">
                                <img :src="imageSrc" alt="Product Image" style="max-width: 100%; max-height: 100px;">
                            </div>
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

import { onMounted, reactive, ref, computed } from 'vue';
import { useProductStore } from '@/store/product';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import FileInput from '../../components/common/FileInput.vue';

const categories = ref([]);
const categoryOptions = computed(() => {
  return categories.value.map((category) => ({
    value: category.id,
    label: category.name,
  }));
});

const form = reactive({
    name: "",
    code: "",
    brand: "",
    category: "",
    description: "",
    qty: "",
    price_per_qty: "",
    manufacture_day: "",
    expiry_day: "",
    image: null,
});
const errors = ref({});
const router = useRouter();
const productStore = useProductStore();
const notify = useNotify();

async function getCategoryOptions() {
  try {
    const response = await productStore.getCategories();

    if (response.data) {
      categories.value = response.data;
    }
  } catch (error) {
    console.log(error);
  }
};

const imageSrc = computed(() => {
  if (form.image) {
    return URL.createObjectURL(form.image);
  }
});

const create = async () => {
    try {
        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('code', form.code);
        formData.append('brand', form.brand);
        formData.append('category', form.category);
        formData.append('description', form.description);
        formData.append('qty', form.qty);
        formData.append('price_per_qty', form.price_per_qty);
        formData.append('manufacture_day', form.manufacture_day);
        formData.append('expiry_day', form.expiry_day);
        formData.append('image', form.image);

        await productStore.create(formData);
        errors.value = {};
        notify.success('Added data successfully');
        router.push({ name: 'product.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};

onMounted(async () => {
  await getCategoryOptions();
});

</script>
