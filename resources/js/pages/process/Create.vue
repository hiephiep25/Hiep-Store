<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <SelectBox v-model:model-value="form" name="product_code" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Sản phẩm" :option="productCodeOptions" :errors="errors" />
                            <Input v-model:model-value="form" name="qty" type="number" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Số lượng" :errors="errors" />
                            <SelectBox v-model:model-value="form" name="option" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Lựa chọn xử lí" :option="options" :errors="errors" />
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

import { reactive, ref, onMounted } from 'vue';
import { useProcessStore } from '@/store/process';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import { useOfflineOrderStore } from '@/store/offline-order';
const options = [
    { label: "SALEOFF", value: "SALEOFF" },
    { label: "COOKING", value: "COOKING" },
    { label: "DONATE", value: "DONATE" },
    { label: "DESTROY", value: "DESTROY" },
];

const form = reactive({
    option: '',
    product_code: "",
    qty: "",
});

const productCodeOptions = ref([]);

const errors = ref({});
const router = useRouter();
const processStore = useProcessStore();
const notify = useNotify();
const offlineOrderStore = useOfflineOrderStore();

const loadProductCodes = async () => {
  try {
    const response = await offlineOrderStore.getStoreProductCodes();
    productCodeOptions.value = response.data.map((item) => ({
      label: item.code,
      value: item.code,
      price_per_qty: item.price_per_qty,
      product_name: item.name,
      image: item.image
    }));
  } catch (error) {
    console.error('Lỗi khi tải dữ liệu', error);
  }
};

const create = async () => {
    try {
        await processStore.create(form);
        errors.value = {};
        notify.success('Tạo mới dữ liệu thành công');
        router.push({ name: 'process.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};

onMounted(() => {
  loadProductCodes();
});
</script>
