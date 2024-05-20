<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md">
                    <div class="row justify-center">
                        <div class="col-12">
                            <SelectBox v-model:model-value="form" name="product_code" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Sản phẩm" :option="productCodeOptions" :errors="errors" disable/>
                            <Input v-model:model-value="form" name="qty" type="number" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Số lượng" :errors="errors" disable/>
                            <SelectBox v-model:model-value="form" name="option" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="Lựa chọn xử lí" :errors="errors" disable/>
                        </div>
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useProcessStore } from '@/store/process';
import { useRouter, useRoute } from 'vue-router';
import useNotify from '@/utils/notify';
import Input from '../../components/common/Input.vue';
import SelectBox from '../../components/common/SelectBox.vue';
import { storeToRefs } from "pinia";

const form = reactive({
    option: '',
    product_code: "",
    qty: "",
});


const { params } = useRoute();
const id = params.id;

const errors = ref({});
const router = useRouter();
const processStore = useProcessStore();
const notify = useNotify();
const getProcess = async () => {
    try {
        const process = await processStore.getProcess(id);
        form.option = process.option;
        form.product_code = process.product_code;
        form.qty = process.qty;
    } catch (error) {
        throw error;
    }
};

getProcess();
</script>
