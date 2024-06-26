<template>
  <q-page>
    <div class="q-pa-md">
      <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
        <div class="row">
          <q-btn
            v-if="isAdmin"
            class="btn"
            color="primary"
            label="Tạo mới"
            @click="navigateToRegistrationPage()"
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
                :rows="processes"
                :columns="columns"
                :virtual-scroll-sticky-size-start="48"
                row-key="id"
                v-model:pagination="pagination"
                @request="onRequest"
              >
                <template v-slot:body-cell-actions="props">
                  <q-td :props="props">
                    <q-btn
                      class="q-ml-sm"
                      icon="edit"
                      color="primary"
                      size="sm"
                      @click="handleEdit(props.row)"
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
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useProcessStore } from "@/store/process";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/store/auth";

const router = useRouter();
const processStore = useProcessStore();
const separator = ref("vertical");
const { processes, pagination } = storeToRefs(processStore);

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const isAdmin = ref(user.value.role == "ADMIN");

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
    name: "product_code",
    align: "center",
    label: "Mã sản phẩm",
    field: "product_code",
  },
  {
    name: "qty",
    align: "center",
    label: "Số lượng xử lí",
    field: "qty",
  },
  {
    name: "store_id",
    align: "center",
    label: "Thuộc cửa hàng",
    field: "store_id",
  },
  {
    name: "option",
    align: "center",
    label: "Lựa chọn xử lí",
    field: "option",
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
      ];
    },
  },
]);

const onRequest = async ({ pagination }) => {
  await processStore.getProcesses({
    page: pagination.page,
    per_page: pagination.rowsPerPage,
  });
};
const navigateToRegistrationPage = () => {
  router.push({ name: "process.create" });
};
const handleEdit = (process) => {
  router.push(`/process/${process.id}`);
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
  return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

processStore.getProcesses({});
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
