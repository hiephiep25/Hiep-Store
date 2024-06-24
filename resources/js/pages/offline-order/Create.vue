<template>
  <q-page class="q-ma-md">
    <q-card>
      <q-card-section class="align-self-center">
        <q-form class="q-gutter-md" @submit="create()">
          <div class="row justify-center">
            <div class="col-12">
              <SelectBox
                v-model:model-value="form"
                name="payment_type"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Hình thức thanh toán"
                :option="paymentTypeOptions"
                :errors="errors"
              />
            </div>
          </div>
          <div class="row justify-center">
            <div class="col-6">
              <SelectBox
                v-model:model-value="newProduct"
                name="product_code"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Sản phẩm"
                :option="productCodeOptions"
                :errors="errors"
              />
            </div>
            <div class="col-6">
              <Input
                v-model:model-value="newProduct"
                name="qty"
                type="number"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Số lượng"
                :errors="errors"
              />
            </div>
          </div>
          <div class="row justify-center">
            <q-btn @click="addProduct" color="green" label="Thêm sản phẩm" />
          </div>
          <div class="row justify-center">
            <q-list bordered v-if="selectedProducts.length > 0">
              <q-item v-for="(product, index) in selectedProducts" :key="index">
                <q-item-section avatar>
                  <q-img
                    :src="product.image"
                    alt="Product Image"
                    style="width: 50px; height: 50px"
                  ></q-img>
                </q-item-section>
                <q-item-section>
                  <q-item-label
                    >{{ product.product_code }} - {{ product.product_name }} -
                    Qty: {{ product.qty }}</q-item-label
                  >
                </q-item-section>
                <q-item-section side top>
                  <q-btn
                    @click="removeProduct(index)"
                    icon="delete"
                    color="negative"
                  />
                </q-item-section>
              </q-item>
            </q-list>
          </div>
          <div class="row justify-center">
            <div>Tổng tiền: {{ calculateTotal }} VND</div>
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
import { reactive, ref, computed, onMounted } from "vue";
import { useOfflineOrderStore } from "@/store/offline-order";
import { useRouter, useRoute } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../../components/common/Input.vue";
import SelectBox from "../../components/common/SelectBox.vue";

const form = reactive({
  payment_type: "",
});

const paymentTypeOptions = [
  { label: "CASH", value: "CASH" },
  { label: "E_WALLET", value: "E_WALLET" },
  { label: "CARD", value: "CARD" },
];

const productCodeOptions = ref([]);

const newProduct = reactive({
  product_code: "",
  qty: "",
  image: "",
});
const { params } = useRoute();
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
    selectedProduct.image = selectedProductInfo.image;
    const existingProduct = selectedProducts.value.find(
      (product) => product.product_code === selectedProduct.product_code
    );

    if (existingProduct) {
      existingProduct.qty =
        Number(existingProduct.qty) + Number(selectedProduct.qty);
    } else {
      selectedProducts.value.push(selectedProduct);
    }
    newProduct.product_code = "";
    newProduct.qty = "";
  } else {
    console.error(
      "Product info not found for code:",
      selectedProduct.product_code
    );
  }
};

const removeProduct = (index) => {
  selectedProducts.value.splice(index, 1);
};

const calculateTotal = computed(() => {
  return selectedProducts.value.reduce((total, product) => {
    const productTotal = Number(product.qty) * Number(product.price_per_qty);
    return total + productTotal;
  }, 0);
});

const loadProductCodes = async () => {
  try {
    const response = await offlineOrderStore.getStoreProductCodes();
    productCodeOptions.value = response.data.map((item) => ({
      label: item.product_code,
      value: item.product_code,
      price_per_qty: item.product.price_per_qty,
      product_name: item.product_name,
      image: item.image,
    }));
  } catch (error) {
    console.error("Lỗi khi tải dữ liệu", error);
  }
};

const create = async () => {
  try {
    const total = calculateTotal.value;
    await offlineOrderStore.create({
      ...form,
      products: selectedProducts.value,
      total,
    });
    errors.value = {};
    notify.success("Tạo mới dữ liệu thành công");
    router.push({ name: "offline-order" });
  } catch (error) {
    errors.value = error?.response?.data?.error;
    notify.error(error.response.data.error);
  }
};

onMounted(() => {
  loadProductCodes();
});
</script>
