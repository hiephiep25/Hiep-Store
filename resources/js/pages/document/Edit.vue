<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="update()" enctype="multipart/form-data">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="product_name" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Product's name" :errors="errors" />
                            <SelectBox v-model:model-value="form" name="category" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Category" :option="categoryOptions" :errors="errors" />
                            <Input v-model:model-value="form" name="description" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Description" :errors="errors" />
                            <Input v-model:model-value="form" name="qty" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Qty" :errors="errors" />
                            <Input v-model:model-value="form" name="price" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Price" :errors="errors" />
                            <Input v-model:model-value="form" name="manufacture_day" type="date"
                                width-common="col-8 q-ml-lg" width-label="col-2" label="Manufacture day" :errors="errors" />
                            <Input v-model:model-value="form" name="expiry_day" type="date" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Expiry day" :errors="errors" />
                            <FileInput v-model:model-value="form" name="image" label="Image" :errors="errors" />
                            <div class="row justify-center" v-if="form.image">
                                <img :src="imageSrc" alt="Product Image" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <div class="row justify-center" v-if="!form.image">
                                <img :src="oldImageSrc" alt="Product Image" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <FileInput v-model:model-value="form" name="license_company" label="License Company" :errors="errors" />
                            <div class="row justify-center" v-if="form.license_company">
                                <img :src="licenseCompanySrc" alt="License Company" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <div class="row justify-center" v-if="!form.license_company">
                                <img :src="oldLicenseCompanySrc" alt="License Company" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <FileInput v-model:model-value="form" name="license_product" label="License Product" :errors="errors" />
                            <div class="row justify-center" v-if="form.license_product">
                                <img :src="licenseProductSrc" alt="License Product" style="max-width: 100%; max-height: 100px;">
                            </div>
                            <div class="row justify-center" v-if="!form.license_product">
                                <img :src="oldLicenseProductSrc" alt="License Product" style="max-width: 100%; max-height: 100px;">
                            </div>
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

import { onMounted, reactive, ref, computed } from 'vue';
import { useProductStore } from '@/store/product';
import { useDocumentStore } from '@/store/document';
import { useRouter, useRoute } from 'vue-router';
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
    category: "",
    description: "",
    qty: "",
    price: "",
    manufacture_day: "",
    expiry_day: "",
    image: null,
    license_company: null,
    license_product: null,
});

var oldImageSrc = null;
var oldLicenseCompanySrc = null;
var oldLicenseProductSrc = null;

const { params } = useRoute();
const id = params.id;

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

const getDocument = async () => {
    try {
        const document = await documentStore.getDocument(id);
        form.product_name = document.product_name;
        form.category = document.category;
        form.description = document.description;
        form.qty = document.qty;
        form.price = document.price;
        if (document.manufacture_day) {
            const manufactureDate = new Date(document.manufacture_day);
            const formattedManufactureDay = manufactureDate.toISOString().split('T')[0];
            form.manufacture_day = formattedManufactureDay;
        } else {
            form.manufacture_day = "";
        }
        if (document.expiry_day) {
            const expiryDate = new Date(document.expiry_day);
            const formattedExpiryDay = expiryDate.toISOString().split('T')[0];
            form.expiry_day = formattedExpiryDay;
        } else {
            form.expiry_day = "";
        }
        oldImageSrc = document.image;
        oldLicenseCompanySrc = document.license_company;
        oldLicenseProductSrc = document.license_product;
    } catch (error) {
        throw error;
    }
};

async function update() {
    try {
        const formData = new FormData();
        formData.append('supplier_id', authStore.user.id);
        formData.append('product_name', form.product_name);
        formData.append('category', form.category);
        formData.append('description', form.description);
        formData.append('qty', form.qty);
        formData.append('price', form.price);
        formData.append('manufacture_day', form.manufacture_day);
        formData.append('expiry_day', form.expiry_day);
        if(form.image) {
            formData.append('image', form.image);
        }
        if(form.license_company) {
            formData.append('license_company', form.license_company);
        }
        if(form.license_product) {
            formData.append('license_product', form.license_product);
        }

        await documentStore.updateDocument(id, formData);
        errors.value = {};
        notify.success('Edited the data successfully');
        router.push({ name: 'document.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

getDocument();

onMounted(async () => {
    await getCategoryOptions();
});

</script>
