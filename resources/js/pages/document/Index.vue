<template>
    <q-page>
        <div class="q-pa-md">
            <q-card class="my-card bg-white text-white q-pa-md">
                <q-form @submit="onSubmit">
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonSelectBox v-model:model-value="status" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Trạng thái" :select-options="statusOptions" />
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
                    <q-btn class="btn" color="primary" label="Tạo mới" @click="navigateToRegistrationPage" />
                </div>
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="không có dữ liệu"
                                class="header-table-custom" rows-per-page-label="Số lượng trên 1 trang"
                                :pagination-label="getPaginationLabel" :rows="documents" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-image="props">
                                    <q-td :props="props">
                                        <img :src="props.row.image" alt="Ảnh"
                                            style="width: 50px; height: auto;" />
                                    </q-td>
                                </template>
                                <template v-slot:body-cell-actions="props">
                                    <q-td :props="props">
                                        <q-btn class="q-ml-sm" icon="edit" color="primary" size="sm"
                                            @click="handleEdit(props.row)" />
                                        <q-btn class="q-ml-sm" icon="delete" color="red" size="sm"
                                            @click="handleDelete(props.row)" v-if="props.row.status != 'APPROVED'"/>
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
                    <span class="q-ml-sm">Xác nhận xóa tài liệu {{ documentDelete.name }}?</span>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Hủy" color="primary" v-close-popup />
                    <q-btn flat label="OK" color="negative" v-close-popup @click="confirmed()" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useDocumentStore } from "@/store/document";
import { useAuthStore } from "@/store/auth";
import { storeToRefs } from "pinia";
import CommonSelectBox from "../../components/common/CommonSelectBox.vue"

const router = useRouter();
const documentStore = useDocumentStore();
const authStore = useAuthStore();
const separator = ref("vertical");
const { documents, pagination } = storeToRefs(documentStore);
const { user } = storeToRefs(authStore);
const status = ref("");
const documentDelete = ref({});
const confirm = ref(false);
const notify = useNotify();
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
        name: "product_name",
        align: "center",
        label: "Tên sản phẩm",
        field: "product_name",
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
        name: "price",
        align: "center",
        label: "Giá bán (cung cấp)",
        field: "price",
    },
    {
        name: "image",
        align: "center",
        label: "Ảnh",
        field: "image",
    },
    {
        name: "status",
        align: "center",
        label: "Trạng thái",
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
                {
                    label: "Xóa",
                    onClick: () => handleDelete(row),
                    icon: "delete",
                },
            ];
        },
    },
]);

const statusOptions = [
  { label: 'Được chấp nhận', value: 'APPROVED' },
  { label: 'Đợi phản hồi', value: 'AWAIT_APPROVAL' },
  { label: 'Bị từ chối', value: 'DENIED' },
];

const onRequest = async ({ pagination }) => {
    await documentStore.getMyDocuments({
        status: status.value.label,
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const resetSearch = () => {
    status.value = "";
    documentStore.getMyDocuments();
};

const handleEdit = (document) => {
    router.push(`/documents/${document.id}`);
};

const handleDelete = (evt) => {
    confirm.value = true;
    documentDelete.value = documents.value.find(function (c) {
        return c.id == evt.id;
    });
};

const confirmed = async () => {
    try {
        await documentStore.deleteDocument(documentDelete.value.id);
        notify.success("Dữ liệu đã được xóa.");
        documentStore.getMyDocuments();
    } catch (error) {
        notify.error(error.response.data.message);
    }
};

const onSubmit = async () => {
    await documentStore.getMyDocuments({
        status: status.value.label,
        page: pagination.value.page,
        per_page: pagination.value.rowsPerPage,
    });
};

const navigateToRegistrationPage = () => {
    router.push("/documents/create");
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

onMounted(async () => {
    documentStore.getMyDocuments({});
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
