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
                                        width-label="col-1" label="Tên khuyến mại" />
                                </div>
                                <div class="col-6">
                                    <CommonInput v-model:model-value="code" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="Mã Code" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <CommonInput v-model:model-value="value" type="text" width-common="col-12 q-ml-lg"
                                        width-label="col-1" label="Giá trị khuyến mại" />
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
                                <template v-slot:body-cell-start_date="props">
                                    <q-td :props="props">{{ formatDate(props.row.start_date) }}</q-td>
                                </template>
                                <template v-slot:body-cell-expiration_date="props">
                                    <q-td :props="props">{{ formatDate(props.row.expiration_date) }}</q-td>
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
                    <span class="q-ml-sm">Xác nhận xóa khuyến mại {{ discountDelete.name }}?</span>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn flat label="Hủy" color="primary" v-close-popup />
                    <q-btn flat label="Xác nhận" color="negative" v-close-popup @click="confirmed()" />
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
        label: "Tên khuyến mại",
        field: "name",
        sortable: true,
    },
    {
        name: "code",
        align: "center",
        label: "Mã Code",
        field: "code",
        sortable: true,
    },
    {
        name: "value",
        align: "center",
        label: "Giá trị khuyến mại (%)",
        field: "value",
        sortable: true,
    },
    {
        name: "start_date",
        align: "center",
        label: "Thời gian bắt đầu",
        field: "start_date",
        sortable: true,
    },
    {
        name: "expiration_date",
        align: "center",
        label: "Thời gian hết hạn",
        field: "expiration_date",
        sortable: true,
    },
    {
        name: "availability",
        align: "center",
        label: "Khả dụng",
        field: "availability",
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

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "numeric", day: "numeric" };
    const date = new Date(dateString);
    return date.toLocaleDateString("en-US", options);
};

const onRequest = async ({ pagination }) => {
    await discountStore.getDiscounts({
        name: name.value,
        code: code.value,
        value: value.value,
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
        notify.success("Dữ liệu đã được xóa");
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
