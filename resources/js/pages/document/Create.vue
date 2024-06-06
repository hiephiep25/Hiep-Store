<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()" enctype="multipart/form-data">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="product_name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Tên sản phẩm" :errors="errors" />
                            <SelectBox v-model:model-value="form" name="category_id" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Danh mục" :option="categoryOptions" :errors="errors" />
                            <Input v-model:model-value="form" name="description" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Mô tả" :errors="errors" />
                            <Input v-model:model-value="form" name="qty" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Số lượng" :errors="errors" />
                            <Input v-model:model-value="form" name="price" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Giá nhập hàng" :errors="errors" />
                            <Input v-model:model-value="form" name="manufacture_day" type="date"
                                width-common="col-8 q-ml-lg" width-label="col-2" label="Ngày sản xuất" :errors="errors" />
                            <Input v-model:model-value="form" name="expiry_day" type="date" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Hạn sử dụng" :errors="errors" />
                            <FileInput v-model:model-value="form" name="image" label="Ảnh sản phẩm" :errors="errors" />
                            <div class="row justify-center" v-if="form.image">
                                <img :src="imageSrc" alt="Ảnh" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <FileInput v-model:model-value="form" name="license_company" label="Giấy phép kinh doanh" :errors="errors" />
                            <div class="row justify-center" v-if="form.license_company">
                                <img :src="licenseCompanySrc" alt="License company Image" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <FileInput v-model:model-value="form" name="license_product" label="Giấy phép sản phẩm" :errors="errors" />
                            <div class="row justify-center" v-if="form.license_product">
                                <img :src="licenseProductSrc" alt="License product Image" style="max-width: 100%; max-height: 100px;">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn type="submit" color="primary" label="Tạo mới" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>

import { onMounted, reactive, ref, computed } from 'vue';
import { useProductStore } from '@/store/product';
import { useDocumentStore } from '@/store/document';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import FileInput from '../../components/common/FileInput.vue';
import { useAuthStore } from "@/store/auth";

const authStore = useAuthStore();

const categories = ref([]);
const categoryOptions = computed(() => {
  return categories.value.map((category) => ({
    value: category.id,
    label: category.name,
  }));
});

const form = reactive({
    suppplier_id: "",
    product_name: "",
    category_id: "",
    description: "",
    qty: "",
    price: "",
    manufacture_day: "",
    expiry_day: "",
    image: null,
    license_company: null,
    license_product: null,
});
const errors = ref({});
const router = useRouter();
const productStore = useProductStore();
const documentStore = useDocumentStore();
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

const licenseCompanySrc = computed(() => {
  if (form.license_company) {
    return URL.createObjectURL(form.license_company);
  }
});

const licenseProductSrc = computed(() => {
  if (form.license_product) {
    return URL.createObjectURL(form.license_product);
  }
});

const create = async () => {
    try {
        const formData = new FormData();
        formData.append('supplier_id', authStore.user.id);
        formData.append('product_name', form.product_name);
        formData.append('category_id', form.category_id);
        formData.append('description', form.description);
        formData.append('qty', form.qty);
        formData.append('price', form.price);
        formData.append('manufacture_day', form.manufacture_day);
        formData.append('expiry_day', form.expiry_day);
        formData.append('image', form.image);
        formData.append('license_company', form.license_company);
        formData.append('license_product', form.license_product);

        await documentStore.create(formData);
        errors.value = {};
        notify.success('Tạo mới dữ liệu thành công');
        router.push({ name: 'document.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};

onMounted(async () => {
  await getCategoryOptions();
});

</script>
