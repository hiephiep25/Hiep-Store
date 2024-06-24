<template>
  <q-page>
    <div class="q-pa-md">
      <q-card v-if="isAdmin" class="my-card bg-white text-white q-pa-md">
        <q-form @submit="onSubmit">
          <div class="row justify-center">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <CommonSelectBox
                    v-model:model-value="store"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Cửa hàng"
                    :select-options="storeOptions"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center q-mt-md">
            <q-btn
              type="submit"
              class="btn q-ml-sm"
              color="primary"
              label="Tìm kiếm"
            />
          </div>
        </q-form>
      </q-card>
      <q-card
        v-if="isAdmin"
        class="my-card bg-white text-white q-pa-sm q-mt-lg"
      >
        <q-form @submit="onUpdate">
          <div class="row justify-center">
            <div class="col">
              <div class="row justify-center">
                <div class="col-6">
                  <q-select
                    outlined
                    :dense="true"
                    hide-bottom-space
                    class="q-pa-sm q-pl-sm q-ml-lg col-12 self-center"
                    v-model="selectedProduct"
                    :options="availableProductOptions"
                    label="Mã sản phẩm"
                    filled
                  >
                  </q-select>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <CommonInput
                    v-model:model-value="form.add_quantity"
                    type="text"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Số lượng thêm"
                  />
                </div>
                <div class="col-6">
                  <CommonInput
                    v-model:model-value="form.sub_quantity"
                    type="text"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Số lượng bớt"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center q-mt-md">
            <q-btn
              type="submit"
              class="btn q-ml-sm"
              color="primary"
              label="Xuất ra cửa hàng"
            />
          </div>
        </q-form>
      </q-card>
      <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
        <div class="row">
          <div class="col-12 q-mt-md">
            <q-markup-table :separator="separator" flat bordered>
              <q-table
                flat
                bordered
                virtual-scroll
                no-data-label="không có dữ liệu"
                class="header-table-custom"
                rows-per-page-label="Số lượng trên 1 trang"
                :pagination-label="getPaginationLabel"
                :rows="productStores"
                :columns="columns"
                :virtual-scroll-sticky-size-start="48"
                row-key="id"
                v-model:pagination="pagination"
                @request="onRequest"
              >
                <template v-slot:body-cell-image="props">
                  <q-td :props="props">
                    <img
                      :src="props.row.image"
                      alt="Ảnh"
                      style="width: 50px; height: auto"
                    />
                  </q-td>
                </template>
              </q-table>
            </q-markup-table>
          </div>
        </div>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import { useStoreStore } from "@/store/store";
import { useProductStore } from "@/store/product";
import { storeToRefs } from "pinia";
import CommonSelectBox from "../components/common/CommonSelectBox.vue";
import CommonInput from "../components/common/CommonInput.vue";
import useNotify from "@/utils/notify";
import { useAuthStore } from "@/store/auth";

const notify = useNotify();
const errors = ref({});
const storeStore = useStoreStore();
const productStore = useProductStore();
const separator = ref("vertical");
const { stores, productStores, pagination } = storeToRefs(storeStore);
const { availableProducts } = storeToRefs(productStore);
const store = ref({ value: 1, label: 1 });
const storeOptions = stores.value.map((store) => ({
  label: store.id,
  value: store.id,
}));
const selectedProduct = ref(null);

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const isAdmin = ref(user.value.role == "ADMIN");

const form = reactive({
  store_id: store.value.value,
  product_code: "",
  add_quantity: null,
  sub_quantity: null,
});
const columns = ref([
  {
    name: "code",
    align: "center",
    label: "Mã sản phẩm",
    field: "product_code",
    sortable: true,
  },
  {
    name: "name",
    align: "center",
    label: "Tên sản phẩm",
    field: "product_name",
  },
  {
    name: "image",
    align: "center",
    label: "Ảnh sản phẩm",
    field: "image",
  },
  {
    name: "quantity",
    align: "center",
    label: "Số lượng",
    field: "qty",
    sortable: true,
  },
]);

const onSubmit = async () => {
  await storeStore.getProductStores({
    store_id: store.value.value,
    page: pagination.value.page,
    per_page: pagination.value.rowsPerPage,
  });
};

const onRequest = async ({ pagination }) => {
  await storeStore.getProductStores({
    store_id: store.value.value,
    page: pagination.page,
    per_page: pagination.rowsPerPage,
  });
};

const onUpdate = async () => {
  try {
    form.store_id = store.value.value;
    form.product_code = selectedProduct.value?.value || "";
    await storeStore.updateProductStores(form);
    errors.value = {};
    form.product_code = "";
    form.add_quantity = null;
    form.sub_quantity = null;
    notify.success("Xuất ra cửa hàng thành công");
    storeStore.getProductStores({ store_id: store.value.value });
  } catch (error) {
    errors.value = error?.response?.data?.errors;
    notify.error(error.response.data.message);
  }
};

const availableProductOptions = computed(() =>
  availableProducts.value.map((product) => ({
    label: product.name + " - " + product.code,
    value: product.code,
  }))
);

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
  return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

storeStore.getStores();
storeStore.getProductStores({ store_id: store.value.value });
productStore.getAvailableProducts();
</script>

<style lang="scss" scoped>
.btn {
  box-sizing: border-box;
  justify-content: center;
  padding: 10px;
  width: 100px;
  height: 30px;
  font-style: normal;
  font-weight: 700;
  font-size: 14px;
  line-height: 17px;
}
</style>
