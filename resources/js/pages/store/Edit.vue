<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="update()">
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
                        <q-btn type="submit" color="primary" label="Chỉnh sửa" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useStoreStore } from '@/store/store';
import { useRouter, useRoute } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import { storeToRefs } from "pinia";

const status = [
    { label: "ACTIVE", value: "ACTIVE" },
    { label: "PENDING", value: "PENDING" },
];

const form = reactive({
    user_name: "",
    user_email: "",
    store_id: "",
    status: "",
});

const { params } = useRoute();
const id = params.id;

const errors = ref({});
const router = useRouter();
const storeStore = useStoreStore();
const notify = useNotify();
const getStore = async () => {
    try {
        const store = await storeStore.getStore(id);
        form.address = store.address;
        form.phone_contact = store.phone_contact;
        form.status = store.status;
    } catch (error) {
        throw error;
    }
};

async function update() {
    try {
        await storeStore.updateStore(id, form);
        errors.value = {};
        notify.success('Chỉnh sửa thành công');
        router.push({ name: 'admin-store.index' });
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

getStore();
</script>
