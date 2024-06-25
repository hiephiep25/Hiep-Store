<template>
  <q-page class="q-ma-md">
    <q-card>
      <q-card-section class="align-self-center">
        <q-form class="q-gutter-md" @submit="create()">
          <div class="row justify-center">
            <div class="col-12">
              <Input
                v-model:model-value="form"
                name="name"
                type="text"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Tên khuyến mãi"
                :errors="errors"
              />
              <Input
                v-model:model-value="form"
                name="code"
                type="text"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Mã Code"
                :errors="errors"
              />
              <Input
                v-model:model-value="form"
                name="description"
                type="text"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Mô tả"
                :errors="errors"
              />
              <Input
                v-model:model-value="form"
                name="start"
                type="datetime-local"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Ngày bắt đầu"
                :errors="errors"
              />
              <Input
                v-model:model-value="form"
                name="end"
                type="datetime-local"
                width-common="col-8 q-ml-lg"
                width-label="col-2"
                label="Hạn sử dụng"
                :errors="errors"
              />
              <FileInput
                id="image"
                v-model:model-value="form"
                name="image"
                label="Ảnh discount"
                :errors="errors"
              />
              <div class="row justify-center" v-if="form.image">
                <img
                  :src="imageSrc"
                  alt="Ảnh"
                  style="max-width: 100%; max-height: 100px"
                />
              </div>
            </div>
          </div>
          <div class="row justify-center">
            <q-btn id="submit" type="submit" color="primary" label="Tạo mới" />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { reactive, ref, computed } from "vue";
import { useDiscountStore } from "@/store/discount";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../../components/common/Input.vue";
import FileInput from "../../components/common/FileInput.vue";

const form = reactive({
  name: "",
  code: "",
  description: "",
  start: "",
  end: "",
  image: null,
});
const errors = ref({});
const router = useRouter();
const discountStore = useDiscountStore();
const notify = useNotify();

const imageSrc = computed(() => {
  if (form.image) {
    return URL.createObjectURL(form.image);
  }
});

const create = async () => {
  try {
    const formData = new FormData();
    formData.append("name", form.name);
    formData.append("code", form.code);
    formData.append("description", form.description || '');
    formData.append("start", form.start);
    formData.append("end", form.end);
    formData.append("image", form.image);
    await discountStore.create(formData);
    errors.value = {};
    notify.success("Tạo mới dữ liệu thành công");
    router.push({ name: "discount.index" });
  } catch (error) {
    errors.value = error?.response?.data?.errors;
    notify.error(error.response.data.message);
  }
};
</script>
