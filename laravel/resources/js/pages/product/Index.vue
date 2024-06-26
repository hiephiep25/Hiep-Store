<template>
  <q-page>
    <div class="q-pa-md">
      <q-card class="my-card bg-white text-white q-pa-md">
        <q-form @submit="onSubmit">
          <div class="row justify-center">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <CommonInput
                    v-model:model-value="name"
                    type="text"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Tên"
                  />
                </div>
                <div class="col-6">
                  <CommonInput
                    v-model:model-value="code"
                    type="text"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Mã Code"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <CommonInput
                    v-model:model-value="brand"
                    type="text"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Brand"
                  />
                </div>
                <div class="col-6">
                  <CommonSelectBox
                    v-model:model-value="category"
                    width-common="col-12 q-ml-lg"
                    width-label="col-2"
                    label="Danh mục sản phẩm"
                    :select-options="categoryOptions"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center q-mt-md">
            <q-btn
              type="reset"
              class="btn"
              color="primary"
              label="Đặt lại"
              @click="resetSearch"
            />
            <q-btn
              type="submit"
              class="btn q-ml-sm"
              color="primary"
              label="Tìm kiếm"
            />
          </div>
        </q-form>
      </q-card>
      <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
        <div class="row">
          <q-btn
            id="create-new-product-button"
            class="btn"
            color="primary"
            label="Tạo mới"
            @click="navigateToRegistrationPage"
          />
        </div>
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
                :rows="products"
                :columns="columns"
                :virtual-scroll-sticky-size-start="48"
                row-key="id"
                v-model:pagination="pagination"
                @request="onRequest"
              >
                <template v-slot:body-cell-image="props">
                  <q-td :props="props">
                    <img
                      :src="getUrl(props.row.image)"
                      alt="Ảnh"
                      style="width: 50px; height: auto"
                    />
                  </q-td>
                </template>
                <template v-slot:body-cell-actions="props">
                  <q-td :props="props">
                    <q-btn
                      class="q-ml-sm"
                      icon="edit"
                      color="primary"
                      size="sm"
                      @click="handleEdit(props.row)"
                    />
                    <q-btn
                      class="q-ml-sm"
                      icon="delete"
                      color="red"
                      size="sm"
                      @click="handleDelete(props.row)"
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
  <div class="q-pa-md">
    <q-dialog v-model="confirm" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <span class="q-ml-sm"
            >Xác nhận xóa sản phẩm {{ productDelete.name }}?</span
          >
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Hủy" color="primary" v-close-popup />
          <q-btn
            flat
            label="OK"
            color="negative"
            v-close-popup
            @click="confirmed()"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useProductStore } from "@/store/product";
import { storeToRefs } from "pinia";
import CommonInput from "../../components/common/CommonInput.vue";
import CommonSelectBox from "../../components/common/CommonSelectBox.vue";
const env = import.meta.env;
const router = useRouter();
const productStore = useProductStore();
const separator = ref("vertical");
const name = ref("");
const code = ref("");
const brand = ref("");
const category = ref("");
const { products, pagination } = storeToRefs(productStore);
const productDelete = ref({});
const confirm = ref(false);
const notify = useNotify();
const getUrl = (path) => {
  return path ? `${env.VITE_APP_URL}/${path}` : "";
};
const columns = ref([
  {
    name: "id",
    required: true,
    label: "ID",
    align: "left",
    field: "id",
    sortable: true,
  },
  {
    name: "name",
    align: "center",
    label: "Tên",
    field: "name",
    sortable: true,
  },
  {
    name: "code",
    align: "center",
    label: "Mã Code",
    field: "code",
    sortable: true,
  },
  {
    name: "brand",
    align: "center",
    label: "Brand",
    field: "brand",
    sortable: true,
  },
  {
    name: "category_id",
    align: "center",
    label: "Danh mục",
    field: "category_id",
    sortable: true,
  },
  {
    name: "qty",
    align: "center",
    label: "Số lượng",
    field: "qty",
  },
  {
    name: "price_per_qty",
    align: "center",
    label: "Giá",
    field: "price_per_qty",
  },
  {
    name: "image",
    align: "center",
    label: "Ảnh",
    field: "image",
  },
  {
    name: "availability",
    align: "center",
    label: "Khả dụng",
    field: "availability",
  },
  {
    name: "actions",
    label: "Hành động",
    field: "actions",
    align: "center",
    format: (val, row) => {
      return [
        {
          label: "Chỉnh sửa",
          onClick: () => handleEdit(row),
          icon: "edit_square",
        },
        {
          label: "Xóa",
          onClick: () => handleDelete(row),
          icon: "delete",
        },
      ];
    },
  },
]);

const categories = ref([]);
const categoryOptions = computed(() => {
  return categories.value.map((category) => ({
    value: category.id,
    label: category.name,
  }));
});

async function getCategoryOptions() {
  try {
    const response = await productStore.getCategories();

    if (response.data) {
      categories.value = response.data;
    }
  } catch (error) {
    console.log(error);
  }
}

const onRequest = async ({ pagination }) => {
  await productStore.getProducts({
    name: name.value,
    code: code.value,
    brand: brand.value,
    category_id: category.value.value,
    page: pagination.page,
    per_page: pagination.rowsPerPage,
  });
};

const resetSearch = () => {
  name.value = "";
  code.value = "";
  brand.value = "";
  category.value = "";
  productStore.getProducts();
};

const handleEdit = (product) => {
  router.push(`/products/${product.id}`);
};

const handleDelete = (evt) => {
  confirm.value = true;
  productDelete.value = products.value.find(function (c) {
    return c.id == evt.id;
  });
};

const confirmed = async () => {
  try {
    await productStore.deleteProduct(productDelete.value.id);
    notify.success("Dữ liệu đã được xóa");
    productStore.getProducts();
  } catch (error) {
    notify.error(error.response.data.message);
  }
};

const onSubmit = async () => {
  await productStore.getProducts({
    name: name.value,
    code: code.value,
    brand: brand.value,
    category_id: category.value.value,
    page: pagination.value.page,
    per_page: pagination.value.rowsPerPage,
  });
};

const navigateToRegistrationPage = () => {
  router.push("/products/create");
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
  return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

onMounted(async () => {
  await getCategoryOptions();
  productStore.getProducts({});
});
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
