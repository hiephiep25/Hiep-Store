<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <SelectBox v-model:model-value="form" name="payment_type" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Payment Type" :option="paymentTypeOptions" :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-6">
                            <SelectBox v-model:model-value="newProduct" name="product_code" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Product Code" :option="productCodeOptions" :errors="errors" />
                        </div>
                        <div class="col-6">
                            <Input v-model:model-value="newProduct" name="qty" type="number" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Quantity" :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn @click="addProduct" color="green" label="Add Product" />
                    </div>
                    <div class="row justify-center">
                        <q-list bordered v-if="selectedProducts.length > 0">
                            <q-item v-for="(product, index) in selectedProducts" :key="index">
                                <q-item-section>
                                    <q-item-label>{{ product.product_code }} - {{ product.product_name }} - Qty: {{ product.qty }}</q-item-label>
                                </q-item-section>
                                <q-item-section side top>
                                    <q-btn @click="removeProduct(index)" icon="delete" color="negative" />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                    <div class="row justify-center">
                        <div>Total: {{ calculateTotal }}</div>
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
import { reactive, ref, computed, onMounted } from 'vue';
import { useOfflineOrderStore } from '@/store/offline-order';
import { useRouter, useRoute } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue'
import SelectBox from '../../components/common/SelectBox.vue';

const form = reactive({
    payment_type: '',
});

const paymentTypeOptions = [
    { label: "CASH", value: "CASH" },
    { label: "E_WALLET", value: "E_WALLET" },
    { label: "CARD", value: "CARD" },
];

const productCodeOptions = ref([]);

const newProduct = reactive({
    product_code: '',
    qty: '',
});
const { params } = useRoute();
const store = params.store;
const selectedProducts = ref([]);
const errors = ref({});
const router = useRouter();
const offlineOrderStore = useOfflineOrderStore();
const notify = useNotify();

const addProduct = () => {
    const selectedProduct = { ...newProduct };

    const selectedProductInfo = productCodeOptions.value.find(
        (item) => item.value === selectedProduct.product_code
    );

    if (selectedProductInfo) {
        selectedProduct.price_per_qty = selectedProductInfo.price_per_qty;
        selectedProduct.product_name = selectedProductInfo.product_name;
        selectedProducts.value.push(selectedProduct);
        newProduct.product_code = '';
        newProduct.qty = '';
        updateTotal();
    } else {
        console.error('Product info not found for code:', selectedProduct.product_code);
    }
};

const removeProduct = (index) => {
    selectedProducts.value.splice(index, 1);
    updateTotal();
};

const updateTotal = () => {
    calculateTotal.value;
};

const calculateTotal = computed(() => {
    return selectedProducts.value.reduce((total, product) => {
        const productTotal = Number(product.qty) * Number(product.price_per_qty);
        return total + productTotal;
    }, 0);
});

const loadProductCodes = async (store) => {
  try {
    const response = await offlineOrderStore.getStoreProductCodes(store);
    productCodeOptions.value = response.data.map((item) => ({
      label: item.product_code,
      value: item.product_code,
      price_per_qty: item.product.price_per_qty,
      product_name: item.product_name,
    }));
  } catch (error) {
    console.error('Error loading product codes:', error);
  }
};

const create = async () => {
    try {
        const total = calculateTotal.value;
        await offlineOrderStore.create({
            ...form,
            products: selectedProducts.value,
            total,
        }, store);
        errors.value = {};
        notify.success('Create data successfully');
        router.push({ name: 'offline-order' });
    } catch (error) {
        errors.value = error?.response?.data?.errors;
        notify.error(error.response.data.message);
    }
};

onMounted(() => {
  loadProductCodes(store);
});
</script>
