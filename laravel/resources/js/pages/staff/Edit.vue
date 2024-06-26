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
                v-if="isAdmin"
                v-model:model-value="form"
                name="store_id"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Thuộc cửa hàng"
                :option="stores"
                :errors="errors"
              />
              <SelectBox
                v-model:model-value="form"
                name="status"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Tình trạng"
                :option="status"
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
import { useStaffStore } from "@/store/staff";
import { useStoreStore } from "@/store/store";
import { useAuthStore } from "@/store/auth";

import { useRouter, useRoute } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../../components/common/Input.vue";
import SelectBox from "../../components/common/SelectBox.vue";
import { storeToRefs } from "pinia";

const status = [
  { label: "WORK", value: "WORK" },
  { label: "QUIT", value: "QUIT" },
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
const staffStore = useStaffStore();
const storeStore = useStoreStore();
const notify = useNotify();
const { stores } = storeToRefs(storeStore);
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const isAdmin = ref(user.value.role == "ADMIN");
const getStaff = async () => {
  try {
    const staff = await staffStore.getStaff(id);
    form.user_name = staff.user_name;
    form.user_email = staff.user_email;
    form.store_id = staff.store_id;
    form.status = staff.status;
  } catch (error) {
    throw error;
  }
};

async function update() {
  try {
    await staffStore.updateStaff(id, form);
    errors.value = {};
    notify.success("Chỉnh sửa thành công");
    router.push({ name: "staff.index" });
  } catch (error) {
    errors.value = error?.response?.data?.errors;
    notify.error(error.response.data.message);
  }
}

getStaff();
</script>
