<template>
    <q-page>
        <div class="q-pa-md">
            <q-card class="my-card bg-white text-white q-pa-sm q-mt-lg">
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="no data available"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="storages" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                            </q-table>
                        </q-markup-table>
                    </div>
                </div>
            </q-card>
        </div>
    </q-page>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useStorageStore } from "@/store/storage";
import { storeToRefs } from "pinia";
import CommonSelectBox from "../components/common/CommonSelectBox.vue";

const storageStore = useStorageStore();
const separator = ref("vertical");
const { storages, pagination } = storeToRefs(storageStore);

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
        field: "name",
        sortable: true,
    },
    {
        name: "quantity",
        align: "center",
        label: "Quantity",
        field: "quantity",
        sortable: true,
    }
]);

const getStorages = async () => {
    try {
        const response = await storageStore.getStorages();

        if (response.data) {
            storages.value = response.data;
        }
    } catch (error) {
        console.log(error);
    }
};

const getPaginationLabel = (firstRowIndex, endRowIndex, totalRowsNumber) => {
    return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
};

onMounted(async () => {
    await getStorages();
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
