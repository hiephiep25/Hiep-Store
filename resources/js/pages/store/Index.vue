<template>
    <q-page>
        <div class="q-pa-md">
            <div class="row">
                <q-btn class="btn" color="primary" label="Tạo mới" @click="navigateToRegistrationPage" />
            </div>
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="không có dữ liệu"
                                class="header-table-custom" rows-per-page-label="Số lượng trên 1 trang"
                                :pagination-label="getPaginationLabel" :rows="stores" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-actions="props">
                                    <q-td :props="props">
                                        <q-btn class="q-ml-sm" icon="edit" color="primary" size="sm"
                                            @click="handleEdit(props.row)" />
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
import { useStoreStore } from "@/store/store";
import { storeToRefs } from "pinia";

const router = useRouter();
const storeStore = useStoreStore();
const separator = ref("vertical");
const { stores, pagination } = storeToRefs(storeStore);

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
        name: "address",
        align: "center",
        label: "Địa chỉ",
        field: "address",
        sortable: true,
    },
    {
        name: "phone_contact",
        align: "center",
        label: "SĐT",
        field: "phone_contact",
        sortable: true,
    },
    {
        name: "status",
        align: "center",
        label: "Tình trạng",
        field: "status",
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

const navigateToRegistrationPage = () => {
    router.push("/admin-stores/create");
};
const onRequest = async ({ pagination }) => {
    await storeStore.getStores({
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const handleEdit = (store) => {
    router.push(`/admin-stores/${store.id}`);
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

storeStore.getStores({});
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
