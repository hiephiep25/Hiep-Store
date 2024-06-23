<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <SelectBox v-model:model-value="form" name="store_id" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Cửa hàng" :option="storeOptions" :errors="errors" />
                            <SelectBox v-model:model-value="form" name="product_code" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Sản phẩm (chọn cửa hàng trước)" :option="productCodeOptions" :errors="errors" />
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
import { reactive, ref, onMounted, watch } from 'vue';
import { useProcessStore } from '@/store/process';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import { useOfflineOrderStore } from '@/store/offline-order';
import { useStoreStore } from "@/store/store";
import { storeToRefs } from "pinia";

const options = [
    { label: "COOKING", value: "COOKING" },
    { label: "DONATE", value: "DONATE" },
    { label: "DESTROY", value: "DESTROY" },
];
const storeStore = useStoreStore();
const { stores } = storeToRefs(storeStore);
const storeOptions = ref([]);

const form = reactive({
    store_id: '',
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

const loadStores = async () => {
    try {
        await storeStore.getStores();
        storeOptions.value = stores.value.map(store => ({ label: store.id, value: store.id }));
    } catch (error) {
        console.error('Lỗi khi tải dữ liệu cửa hàng', error);
    }
};

const loadProductCodes = async (storeId) => {
  try {
    const response = await offlineOrderStore.getStoreProductCodes({ store_id: storeId });
    productCodeOptions.value = response.data.map((item) => ({
      label: item.product_code,
      value: item.product_code,
      product_name: item.product_name,
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
        errors.value = error?.response?.data?.errors;
        notify.error(error.response.data.message);
    }
};

watch(() => form.store_id, async (newStoreId) => {
    if (newStoreId) {
        await loadProductCodes(newStoreId);
    } else {
        productCodeOptions.value = [];
    }
});

onMounted(async () => {
    await loadStores();
});
</script>

