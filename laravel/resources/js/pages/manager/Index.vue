<template>
  <q-page>
    <div class="q-pa-md">
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
                :rows="managers"
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
import { useManagerStore } from "@/store/manager";
import { storeToRefs } from "pinia";

const router = useRouter();
const managerStore = useManagerStore();
const separator = ref("vertical");
const { managers, pagination } = storeToRefs(managerStore);

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
    field: "user_name",
    sortable: true,
  },
  {
    name: "email",
    align: "center",
    label: "Email",
    field: "user_email",
    sortable: true,
  },
  {
    name: "store_id",
    align: "center",
    label: "Thuộc cửa hàng",
    field: "store_id",
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
  await managerStore.getManagers({
    page: pagination.page,
    per_page: pagination.rowsPerPage,
  });
};

const handleEdit = (manager) => {
  router.push(`/managers/${manager.id}`);
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
  return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

managerStore.getManagers({});
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
