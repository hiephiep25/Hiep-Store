<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="create()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="address" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Địa chỉ cửa hàng" :errors="errors"/>
                            <Input v-model:model-value="form" name="phone_contact" type="text" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="SĐT cửa hàng" :errors="errors"/>
                            <SelectBox v-model:model-value="form" name="status" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Tình trạng cửa hàng" :option="status" :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn type="submit" color="primary" label="Tạo mới" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>

import { reactive, ref } from 'vue';
import { useStoreStore } from '@/store/store';
import { useRouter } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
const status = [
    { label: "ACTIVE", value: "ACTIVE" },
    { label: "PENDING", value: "PENDING" },
];

const form = reactive({
    address: "",
    phone_contact: "",
    status: ""
});
const errors = ref({});
const router = useRouter();
const storeStore = useStoreStore();
const notify = useNotify();

const create = async () => {
    try {
        await storeStore.create(form);
        errors.value = {};
        notify.success('Tạo mới dữ liệu thành công');
        router.push({ name: 'admin-store.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};
</script>
