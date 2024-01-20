<template>
    <q-page>
        <div class="q-pa-md">
            <q-card class="my-card bg-white text-white q-pa-md">
                <q-form @submit="onSubmit">
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonSelectBox v-model:model-value="storage" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Storage" :select-options="storageOptions" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center q-mt-md">
                        <q-btn type="submit" class="btn q-ml-sm" color="primary" label="Search" />
                    </div>
                </q-form>
            </q-card>
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <q-form @submit="onUpdate">
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonInput v-model:model-value="form.product_code" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Product's code" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonInput v-model:model-value="form.add_quantity" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Add quantity" />
                                </div>
                                <div class="col-6">
                                    <CommonInput v-model:model-value="form.sub_quantity" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-2" label="Sub quantity" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center q-mt-md">
                        <q-btn type="submit" class="btn q-ml-sm" color="primary" label="Export to store" />
                    </div>
                </q-form>
            </q-card>
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="no data available"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="storages" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-image="props">
                                    <q-td :props="props">
                                        <img :src="props.row.image" alt="Product Image"
                                            style="width: 50px; height: auto;" />
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
import { ref, onMounted, reactive } from "vue";
import { useStorageStore } from "@/store/storage";
import { storeToRefs } from "pinia";
import CommonSelectBox from "../components/common/CommonSelectBox.vue";
import CommonInput from "../components/common/CommonInput.vue";
import useNotify from '@/utils/notify';

const notify = useNotify();
const errors = ref({});
const storageStore = useStorageStore();
const separator = ref("vertical");
const { storages, pagination } = storeToRefs(storageStore);
const storage = ref({ value: 1, label: 1 });
const storageOptions = ref([
  { value: 1, label: 1 },
  { value: 2, label: 2 },
]);

const form = reactive({
    storage : storage.value.value,
    product_code: "",
    add_quantity: null,
    sub_quantity: null,
});
const columns = ref([
    {
        name: "code",
        align: "center",
        label: "Code",
        field: "product_code",
        sortable: true,
    },
    {
        name: "name",
        align: "center",
        label: "Product's name",
        field: "product_name",
    },
    {
        name: "image",
        align: "center",
        label: "Product's image",
        field: "image",
    },
    {
        name: "quantity",
        align: "center",
        label: "Quantity",
        field: "quantity",
        sortable: true,
    }
]);

const onSubmit = async () => {
    await storageStore.getStorages({
        storage: storage.value.value,
        page: pagination.value.page,
        per_page: pagination.value.rowsPerPage,
    });
};

const onRequest = async ({ pagination }) => {
    await storageStore.getStorages({
        storage: storage.value.value,
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const onUpdate = async () => {
    try {
        form.storage = storage.value.value;
        await storageStore.updateStorages(form)
        errors.value = {};
        form.product_code = "";
        form.add_quantity = null;
        form.sub_quantity = null;
        notify.success('Export to store successfully');
        storageStore.getStorages({ storage: storage.value.value });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

onMounted(async () => {
    storageStore.getStorages({ storage: storage.value.value });
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
