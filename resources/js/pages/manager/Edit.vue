<template>
  <q-page class="q-ma-md">
    <q-card>
      <q-card-section class="align-self-center">
        <q-form class="q-gutter-md" @submit="update()">
          <div class="row justify-center">
            <div class="col-12">
              <Input
                v-model:model-value="form"
                name="user_name"
                type="text"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Tên"
                :errors="errors"
                disable
              />
              <Input
                v-model:model-value="form"
                name="user_email"
                type="text"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Email"
                :errors="errors"
                disable
              />
              <SelectBox
                v-model:model-value="form"
                name="store_id"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Thuộc cửa hàng"
                :option="stores"
                :errors="errors"
              />
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
import { reactive, ref } from "vue";
import { useManagerStore } from "@/store/manager";
import { useStoreStore } from "@/store/store";
import { useRouter, useRoute } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../../components/common/Input.vue";
import SelectBox from "../../components/common/SelectBox.vue";
import { storeToRefs } from "pinia";

const form = reactive({
  user_name: "",
  user_email: "",
  store_id: "",
});

const { params } = useRoute();
const id = params.id;

const errors = ref({});
const router = useRouter();
const managerStore = useManagerStore();
const storeStore = useStoreStore();
const notify = useNotify();
const { stores } = storeToRefs(storeStore);
const getManager = async () => {
  try {
    const manager = await managerStore.getManager(id);
    form.user_name = manager.user_name;
    form.user_email = manager.user_email;
    form.store_id = manager.store_id;
  } catch (error) {
    throw error;
  }
};

async function update() {
  try {
    await managerStore.updateManager(id, form);
    errors.value = {};
    notify.success("Chỉnh sửa thành công");
    router.push({ name: "manager.index" });
  } catch (error) {
    errors.value = error?.response?.data?.errors;
    notify.error(error.response.data.message);
  }
}

getManager();
</script>
