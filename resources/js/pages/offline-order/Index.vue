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
                                <div class="col-6">
                                    <CommonInput v-model:model-value="from" type="date" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="From" />
                                    <CommonInput v-model:model-value="to" type="date" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="To" />
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
                    <q-btn class="btn" color="primary" label="Create" @click="navigateToRegistrationPage(storage.value)" />
                </div>
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="no data available"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="offlineOrders" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-payment_type="props">
                                    <q-td :props="props">
                                        {{ props.row.order.payment_type }}
                                    </q-td>
                                </template>
                                <template v-slot:body-cell-total="props">
                                    <q-td :props="props">{{ props.row.order.total }}</q-td>
                                </template>
                                <template v-slot:body-cell-created_at="props">
                                    <q-td :props="props">{{ formatDate(props.row.created_at) }}</q-td>
                                </template>
                                <template v-slot:body-cell-actions="props">
                                    <q-td :props="props">
                                        <q-btn class="q-ml-sm" icon="info" color="primary" size="sm"
                                            @click="handleInfo(props.row)" />
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
import { useOfflineOrderStore } from "@/store/offline-order";
import { storeToRefs } from "pinia";
import CommonInput from "../../components/common/CommonInput.vue";
import CommonSelectBox from "../../components/common/CommonSelectBox.vue";

const router = useRouter();
const offlineOrderStore = useOfflineOrderStore();
const separator = ref("vertical");
const from = ref("");
const to = ref("");
const { offlineOrders, pagination } = storeToRefs(offlineOrderStore);
const notify = useNotify();
const storage = ref({ value: 1, label: 1 });
const storageOptions = ref([
    { value: 1, label: 1 },
    { value: 2, label: 2 },
]);
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
        name: "order_id",
        align: "center",
        label: "Order",
        field: "order_id",
        sortable: true,
    },
    {
        name: "payment_type",
        align: "center",
        label: "Payment Type",
        field: "payment_type",
        sortable: true,
    },
    {
        name: "total",
        align: "center",
        label: "Total",
        field: "total",
        sortable: true,
    },
    {
        name: "created_at",
        align: "center",
        label: "Created At",
        field: "created_at",
        sortable: true,
    },
    {
        name: "actions",
        label: "Actions",
        field: "actions",
        align: "center",
        format: (val, row) => {
            return [
                {
                    label: "Info",
                    onClick: () => handleInfo(row),
                    icon: "info_square",
                },
            ];
        },
    },
]);

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "numeric", day: "numeric" };
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", options);
};

const onRequest = async ({ pagination }) => {
    await offlineOrderStore.getOfflineOrders({
        storage: storage.value.value,
        from: from.value,
        to: to.value,
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const resetSearch = () => {
    from.value = "";
    to.value = ""
    offlineOrderStore.getOfflineOrders();
};

const handleInfo = (offlineOrder) => {

};

const onSubmit = async () => {
    await offlineOrderStore.getOfflineOrders({
        storage: storage.value.value,
        from: from.value,
        to: to.value,
        page: pagination.value.page,
        per_page: pagination.value.rowsPerPage,
    });
};

const navigateToRegistrationPage = (storageValue) => {
    router.push({ name: 'offline-order.create', params: { storage: storageValue } });
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

offlineOrderStore.getOfflineOrders({ storage: storage.value.value });
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
