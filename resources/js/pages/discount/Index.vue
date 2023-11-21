<template>
    <q-page>
        <div class="q-pa-md">
            <q-card class="my-card bg-white text-white q-pa-md">
                <q-form @submit="onSubmit">
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonInput v-model:model-value="name" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="Name" />
                                </div>
                                <div class="col-6">
                                    <CommonInput v-model:model-value="code" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="Code" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonInput v-model:model-value="value" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="Value" />
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
                    <q-btn class="btn" color="primary" label="Create" @click="navigateToRegistrationPage" />
                </div>
                <div class="row">
                    <div class="col-12 q-mt-md">
                        <q-markup-table :separator="separator" flat bordered>
                            <q-table flat bordered virtual-scroll no-data-label="no data available"
                                class="header-table-custom" rows-per-page-label="Records per page"
                                :pagination-label="getPaginationLabel" :rows="discounts" :columns="columns"
                                :virtual-scroll-sticky-size-start="48" row-key="id" v-model:pagination="pagination"
                                @request="onRequest">
                                <template v-slot:body-cell-actions="props">
                                    <q-td :props="props">
                                        <q-btn class="q-ml-sm" icon="edit" color="primary" size="sm"
                                            @click="handleEdit(props.row)" />
                                        <q-btn class="q-ml-sm" icon="delete" color="red" size="sm"
                                            @click="handleDelete(props.row)" />
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
                    <span class="q-ml-sm">Confirm delete discount {{ discountDelete.name }}?</span>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Cancel" color="primary" v-close-popup />
                    <q-btn flat label="OK" color="negative" v-close-popup @click="confirmed()" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import { useDiscountStore } from "@/store/discount";
import { storeToRefs } from "pinia";
import CommonInput from "../../components/common/CommonInput.vue";

const router = useRouter();
const discountStore = useDiscountStore();
const separator = ref("vertical");
const name = ref("");
const code = ref("");
const value = ref("");
const quantity = ref("");
const { discounts, pagination } = storeToRefs(discountStore);
const discountDelete = ref({});
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
        name: "name",
        align: "center",
        label: "Name",
        field: "name",
        sortable: true,
    },
    {
        name: "code",
        align: "center",
        label: "Code",
        field: "code",
        sortable: true,
    },
    {
        name: "value",
        align: "center",
        label: "Value (%)",
        field: "value",
        sortable: true,
    },
    {
        name: "quantity",
        align: "center",
        label: "Quantity",
        field: "quantity",
        sortable: true,
    },
    {
        name: "availability",
        align: "center",
        label: "Availability",
        field: "availability",
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

const onRequest = async ({ pagination }) => {
    await discountStore.getDiscounts({
        name: name.value,
        code: code.value,
        value: value.value,
        quantity: quantity.value,
        page: pagination.page,
        per_page: pagination.rowsPerPage,
    });
};

const resetSearch = () => {
    name.value = "";
    code.value = "";
    value.value = "";
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
        notify.success("Data has been deleted.");
        discountStore.getDiscounts();
    } catch (error) {
        notify.error(error.response.data.message);
    }
};

const onSubmit = async () => {
    await discountStore.getDiscounts({
        name: name.value,
        code: code.value,
        value: value.value,
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

discountStore.getDiscounts({});
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
