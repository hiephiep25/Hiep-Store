<template>
    <q-page>
        <div class="q-pa-md">
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="không có dữ liệu"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="staffs" :columns="columns"
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
import { useStaffStore } from "@/store/staff";
import { storeToRefs } from "pinia";

const router = useRouter();
const staffStore = useStaffStore();
const separator = ref("vertical");
const { staffs, pagination } = storeToRefs(staffStore);

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


const onRequest = async ({ pagination }) => {
    await staffStore.getStaffs({
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const handleEdit = (staff) => {
    router.push(`/staffs/${staff.id}`);
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

staffStore.getStaffs({});
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
