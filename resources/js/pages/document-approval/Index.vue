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
                                        width-label="col-2" label="Status" :select-options="statusOptions" />
                                </div>
                                <div class="col-6">
                                    <CommonSelectBox v-model:model-value="supplier_id" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Supplier" :select-options="supplierOptions" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center q-mt-md">
                        <q-btn type="reset" class="btn" color="primary" label="Reset" @click="resetSearch" />
                        <q-btn type="submit" class="btn q-ml-sm" color="primary" label="Search" />
                    </div>
                </q-form>
            </q-card>
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="no data available"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="documents" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-image="props">
                                    <q-td :props="props">
                                        <img :src="props.row.image" alt="Product Image"
                                            style="width: 50px; height: auto;" />
                                    </q-td>
                                </template>
                                <template v-slot:body-cell-actions="props">
                                    <q-td :props="props">
                                        <q-btn class="q-ml-sm" icon="info" color="green" size="sm"
                                            @click="handleDetail(props.row)" />
                                    </q-td>
                                </template>
                            </q-table>
                        </q-markup-table>
                    </div>
                </div>
            </q-card>
        </div>
    </q-page>
    <q-dialog v-model="dialogVisible">
        <q-card style="width: 700px;">
            <div class="q-dialog__content q-pa-md" style="height: 100%; width: 100%;">
                <h4 class="text-h6">Document Details</h4>
                <div class="document-info">
                    <p><strong>Product Name:</strong> {{ selectedDocument.product_name }}</p>
                    <p><strong>Category:</strong> {{ selectedDocument.category }}</p>
                    <p><strong>Quantity:</strong> {{ selectedDocument.qty }}</p>
                    <p><strong>Price:</strong> {{ selectedDocument.price }}</p>
                    <p><strong>Manufacture Day:</strong> {{ selectedDocument.manufacture_day }}</p>
                    <p><strong>Expiry Day:</strong> {{ selectedDocument.expiry_day }}</p>
                </div>
                <div class="document-images">
                    <img :src="selectedDocument.image" alt="Product Image" />
                    <img :src="selectedDocument.license_company" alt="License Company" />
                    <img :src="selectedDocument.license_product" alt="License Product" />
                </div>
                <p></p>
                <p><strong>Status:</strong> <strong>{{ selectedDocument.status }}</strong></p>
            </div>
            <q-card-actions align="center" v-if="selectedDocument.status == 'AWAIT_APPROVAL'">
                <q-btn label="Approval" color="green" @click="approve" />
                <q-btn label="Denied" color="red" @click="deny" />
            </q-card-actions>
            <q-card-actions align="right">
                <q-btn label="Close" color="primary" @click="closeDialog" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useDocumentApprovalStore } from "@/store/document-approval";
import { useAuthStore } from "@/store/auth";
import { storeToRefs } from "pinia";
import CommonSelectBox from "../../components/common/CommonSelectBox.vue"

const router = useRouter();
const documentStore = useDocumentApprovalStore();
const authStore = useAuthStore();
const separator = ref("vertical");
const { documents, pagination } = storeToRefs(documentStore);
const { user } = storeToRefs(authStore);
const status = ref("");
const supplier_id = ref("");
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
        label: "Product name",
        field: "product_name",
        sortable: true,
    },
    {
        name: "category",
        align: "center",
        label: "Category",
        field: "category",
        sortable: true,
    },
    {
        name: "qty",
        align: "center",
        label: "Qty",
        field: "qty",
    },
    {
        name: "price",
        align: "center",
        label: "Price",
        field: "price",
    },
    {
        name: "image",
        align: "center",
        label: "Image",
        field: "image",
    },
    {
        name: "status",
        align: "center",
        label: "Status",
        field: "status",
    },
    {
        name: "actions",
        label: "Actions",
        field: "actions",
        align: "center",
        format: (val, row) => {
            return [
                {
                    label: "Edit",
                    onClick: () => handleEdit(row),
                    icon: "edit_square",
                },
                {
                    label: "Delete",
                    onClick: () => handleDelete(row),
                    icon: "delete",
                },
            ];
        },
    },
]);

const statusOptions = [
    { label: 'APPROVED', value: 'APPROVED' },
    { label: 'AWAIT_APPROVAL', value: 'AWAIT_APPROVAL' },
    { label: 'DENIED', value: 'DENIED' },
];

const suppliers = ref([]);
const supplierOptions = computed(() => {
    return suppliers.value.map((supplier) => ({
        value: supplier.id,
        label: supplier.name,
    }));
});
const dialogVisible = ref(false);
const selectedDocument = ref(null);

const onRequest = async ({ pagination }) => {
    await documentStore.getDocuments({
        status: status.value.label,
        supplier_id: supplier_id.value.value,
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const resetSearch = () => {
    status.value = "";
    documentStore.getDocuments();
};

const handleDetail = (document) => {
    selectedDocument.value = document;
    dialogVisible.value = true;
};

const closeDialog = () => {
    dialogVisible.value = false;
};

const approve = async () => {
    try {
        await documentStore.approve(selectedDocument.value.id);
        notify.success('Success');
        router.push({ name: 'document-approval.index' });
    } catch( error ) {
        console.log(error);
    }
};

const deny = async () => {
    try {
        await documentStore.deny(selectedDocument.value.id);
        notify.success('Success');
        router.push({ name: 'document-approval.index' });
    } catch( error ) {
        console.log(error);
    }
};


const onSubmit = async () => {
    await documentStore.getDocuments({
        status: status.value.label,
        supplier_id: supplier_id.value.value,
        page: pagination.value.page,
        per_page: pagination.value.rowsPerPage,
    });
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

async function getSupplierOptions() {
    try {
        const response = await documentStore.getSuppliers();
        if (response.data) {
            suppliers.value = response.data;
        }
    } catch (error) {
        console.log(error);
    }
};

onMounted(async () => {
    await getSupplierOptions();
    documentStore.getDocuments({});
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

.q-dialog__content {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    justify-content: space-between;
    height: 100%;
}

.document-info {
    margin-bottom: 20px;

    p {
        margin: 5px 0;
    }

    strong {
        margin-right: 5px;
    }
}

.document-images {
    display: flex;
    justify-content: space-between;

    img {
        max-height: 100px;
        margin-top: 10px;
    }
}
</style>
