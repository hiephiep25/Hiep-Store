<template>
  <q-page>
    <div class="q-pa-md">
      <q-card class="my-card bg-white text-white q-pa-md">
        <q-form @submit="onSubmit">
          <div class="row justify-center">
            <div class="col">
              <div class="row">
                <div class="col-6">
                  <CommonInput v-model:model-value="name" type="text" width-common="col-12 q-ml-lg" width-label="col-1"
                    label="Tên khuyến mại" />
                </div>
                <div class="col-6">
                  <CommonInput v-model:model-value="code" type="text" width-common="col-12 q-ml-lg" width-label="col-1"
                    label="Mã Code" />
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-center q-mt-md">
            <q-btn type="reset" class="btn" color="primary" label="Đặt lại" @click="resetSearch" />
            <q-btn type="submit" class="btn q-ml-sm" color="primary" label="Tìm kiếm" />
          </div>
        </q-form>
      </q-card>
      <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
        <div class="row">
          <q-btn id="create-new" class="btn" color="primary" label="Tạo mới" @click="navigateToRegistrationPage" />
        </div>
        <div class="row">
          <div class="col-12 q-mt-md">
            <q-markup-table :separator="separator" flat bordered>
              <q-table flat bordered virtual-scroll no-data-label="không có dữ liệu" class="header-table-custom"
                rows-per-page-label="Số lượng trên 1 trang" :pagination-label="getPaginationLabel" :rows="discounts"
                :columns="columns" :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                @request="onRequest">
                <template v-slot:body-cell-actions="props">
                  <q-td :props="props">
                    <q-btn class="q-ml-sm" icon="playlist_add_check" color="primary" size="sm"
                      @click="editProducts(props.row)" />
                    <q-btn class="q-ml-sm" icon="email" color="info" size="sm"
                      @click="handleSendEmail(props.row)" />
                    <q-btn class="q-ml-sm" icon="edit" color="primary" size="sm" @click="handleEdit(props.row)" />
                    <q-btn class="q-ml-sm" icon="delete" color="red" size="sm" @click="handleDelete(props.row)" />
                  </q-td>
                </template>
                <template v-slot:body-cell-start="props">
                  <q-td :props="props">{{ formatDate(props.row.start) }}</q-td>
                </template>
                <template v-slot:body-cell-end="props">
                  <q-td :props="props">{{ formatDate(props.row.end) }}</q-td>
                </template>
                <template v-slot:body-cell-image="props">
                  <q-td :props="props">
                    <img style="height: 50px" :src="getImageUrl(props.row.image)" />
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
          <span class="q-ml-sm">Xác nhận xóa khuyến mại {{ discountDelete.name }}?</span>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Hủy" color="primary" v-close-popup />
          <q-btn flat label="Xác nhận" color="negative" v-close-popup @click="confirmed()" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>

  <div class="q-pa-md">
    <q-dialog v-model="editProductsDialog" persistent>
      <q-card class="q-pa-md">
        <q-card-section class="row items-center">
          <span class="q-ml-sm">Chỉnh sửa sản phẩm áp dụng cho khuyến mại
            {{ selectedDiscount.name }}?</span>
        </q-card-section>
        <q-card-section>
          <q-table flat bordered :rows="selectedDiscount.products" :columns="productColumns" class="q-mb-md">
            <template v-slot:body-cell-name="props">
              <q-td :props="props">{{ props.row.name }} - {{ props.row.code }}</q-td>
            </template>
            <template v-slot:body-cell-value="props">
              <q-td :props="props">
                <q-input v-model="props.row.pivot.value" type="number" outlined dense class="q-pa-xs" />
              </q-td>
            </template>
            <template v-slot:body-cell-qty="props">
              <q-td :props="props">
                <q-input v-model="props.row.pivot.qty" type="number" outlined dense class="q-pa-xs" />
              </q-td>
            </template>
          </q-table>
          <div class="row q-col-gutter-md q-mb-md">
            <div class="col-12 col-md-6">
              <q-select v-model="newProduct" :options="productOptions" label="Thêm sản phẩm" outlined dense />
            </div>
            <div class="col-12 col-md-3">
              <q-input v-model="newProductValue" label="Value" type="number" outlined dense 
              :rules="[val => (val >= 5 && val <= 80) || 'Giá trị value phải trong khoảng từ 5 đến 80']"/>
            </div>
            <div class="col-12 col-md-3">
              <q-input v-model="newProductQty" label="Số lượng" type="number" outlined dense />
            </div>
          </div>
          <div class="row justify-end q-mb-md">
            <q-btn @click="addProductToDiscount" label="Thêm" color="primary" class="q-mr-sm" />
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Hủy" color="primary" v-close-popup />
          <q-btn flat label="Lưu" color="negative" @click="saveEditedProducts" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>

  <q-dialog v-model="emailConfirmationDialog" persistent>
    <q-card>
      <q-card-section class="row items-center">
        <span class="q-ml-sm">Bạn có muốn gửi email khuyến mại cho tất cả khách hàng không?</span>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn flat label="Hủy" color="primary" v-close-popup />
        <q-btn flat label="Xác nhận" color="negative" @click="confirmSendEmail" />
      </q-card-actions>
    </q-card>
  </q-dialog>

</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useDiscountStore } from "@/store/discount";
import { useProductStore } from "@/store/product";
import { storeToRefs } from "pinia";
import CommonInput from "../../components/common/CommonInput.vue";
import dayjs from "dayjs";
const env = import.meta.env;
const router = useRouter();
const discountStore = useDiscountStore();
const separator = ref("vertical");
const name = ref("");
const code = ref("");
const value = ref("");
const { discounts, pagination } = storeToRefs(discountStore);
const discountDelete = ref({});
const selectedDiscount = ref({});
const confirm = ref(false);
const notify = useNotify();
const productStore = useProductStore();
const { availableProducts } = storeToRefs(productStore);
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
    label: "Tên khuyến mại",
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
    name: "start",
    align: "center",
    label: "Thời gian bắt đầu",
    field: "start",
    sortable: true,
  },
  {
    name: "end",
    align: "center",
    label: "Thời gian hết hạn",
    field: "end",
    sortable: true,
  },
  {
    name: "image",
    align: "center",
    label: "Ảnh",
    field: "image",
    sortable: true,
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

const getImageUrl = (path) => {
  return path ? `${env.VITE_APP_URL}/${path}` : "";
};

const formatDate = (dateString) => {
  const date = dayjs(dateString);
  return date.format("DD/MM/YYYY HH:mm");
};

const onRequest = async ({ pagination }) => {
  await discountStore.getDiscounts({
    name: name.value,
    code: code.value,
    page: pagination.page,
    per_page: pagination.rowsPerPage,
  });
};

const resetSearch = () => {
  name.value = "";
  code.value = "";
  discountStore.getDiscounts();
};

const handleEdit = (discount) => {
  router.push(`/discounts/${discount.id}`);
};

const handleDelete = (evt) => {
  confirm.value = true;
  discountDelete.value = discounts.value.find(function (c) {
    return c.id == evt.id;
  });
};

const confirmed = async () => {
  try {
    await discountStore.deleteDiscount(discountDelete.value.id);
    notify.success("Dữ liệu đã được xóa");
    discountStore.getDiscounts();
  } catch (error) {
    notify.error(error.response.data.message);
  }
};

const onSubmit = async () => {
  await discountStore.getDiscounts({
    name: name.value,
    code: code.value,
    page: pagination.value.page,
    per_page: pagination.value.rowsPerPage,
  });
};

const navigateToRegistrationPage = () => {
  router.push("/discounts/create");
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
  return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

const editProductsDialog = ref(false);
const selectedProducts = ref([]);
const newProduct = ref(null);
const newProductValue = ref(0);
const newProductQty = ref(1);
const productOptions = computed(() =>
  productStore.availableProducts.map((product) => ({
    label: `${product.name} - ${product.code}`,
    value: product.id,
  }))
);

const productColumns = ref([
  {
    name: "name",
    label: "Tên sản phẩm",
    field: "name",
  },
  {
    name: "value",
    label: "Giá trị",
    field: "pivot.value",
    align: "center",
  },
  {
    name: "qty",
    label: "Số lượng",
    field: "pivot.qty",
    align: "center",
  },
]);

const editProducts = (discount) => {
  selectedDiscount.value = discount;
  editProductsDialog.value = true;
};

const addProductToDiscount = () => {
  if (newProduct.value) {
    selectedDiscount.value.products.push({
      id: newProduct.value.value,
      name: newProduct.value.label,
      pivot: {
        value: newProductValue.value,
        qty: newProductQty.value,
      },
    });
    newProduct.value = null;
    newProductValue.value = 0;
    newProductQty.value = 1;
  }
};

const saveEditedProducts = () => {
  discountStore.updateDiscountProducts(
    selectedDiscount.value.id,
    selectedDiscount.value.products
  );
  editProductsDialog.value = false;
  notify.success("Cập nhật thành công");
};

const handleSendEmail = (discount) => {
  selectedDiscount.value = discount;
  emailConfirmationDialog.value = true;
};

const emailConfirmationDialog = ref(false);

const confirmSendEmail = async () => {
  try {
    await discountStore.sendMail(selectedDiscount.value.id);
    notify.success("Email đã được gửi thành công");
  } catch (error) {
    notify.error("Gửi email thất bại");
  } finally {
    emailConfirmationDialog.value = false;
  }
};

discountStore.getDiscounts({});
productStore.getAllAvailableProducts();
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
