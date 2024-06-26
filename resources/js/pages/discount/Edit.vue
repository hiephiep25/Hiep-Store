<template>
  <q-page class="q-ma-md">
    <q-card>
      <q-card-section class="align-self-center">
        <q-form class="q-gutter-md" @submit="update()">
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
                v-model:model-value="form"
                name="image"
                label="Ảnh"
                :errors="errors"
              />
              <div class="row justify-center" v-if="form.image">
                <img
                  :src="imageSrc"
                  alt="Ảnh"
                  style="max-width: 100%; max-height: 100px"
                />
              </div>
              <div class="row justify-center" v-if="!form.image">
                <img
                  :src="oldImageSrc"
                  alt="Ảnh"
                  style="max-width: 100%; max-height: 100px"
                />
              </div>
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
import { reactive, ref, computed } from "vue";
import { useDiscountStore } from "@/store/discount";
import { useRouter, useRoute } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../../components/common/Input.vue";
import FileInput from "../../components/common/FileInput.vue";
const env = import.meta.env;

const form = reactive({
  name: "",
  code: "",
  description: "",
  start: "",
  end: "",
  image: null,
});

const { params } = useRoute();
const id = params.id;

const errors = ref({});
const router = useRouter();
const discountStore = useDiscountStore();
const notify = useNotify();
var oldImageSrc = ref(null);

const imageSrc = computed(() => {
  if (form.image) {
    return URL.createObjectURL(form.image);
  }
});
const getDiscount = async () => {
  try {
    const discount = await discountStore.getDiscount(id);
    form.name = discount.name;
    form.code = discount.code;
    form.description = discount.description;
    form.start= discount.start;
    form.end = discount.end;
    oldImageSrc.value = `${env.VITE_APP_URL}/${discount.image}`
  } catch (error) {
    throw error;
  }
};

async function update() {
  try {
    const formData = new FormData();
    if (form.image) {
      formData.append("image", form.image);
    }
    formData.append("name", form.name);
    formData.append("code", form.code);
    formData.append("description", form.description || '');
    formData.append("start", form.start);
    formData.append("end", form.end);
    await discountStore.updateDiscount(id, formData);
    errors.value = {};
    notify.success("Chỉnh sửa dữ liệu thành công");
    router.push({ name: "discount.index" });
  } catch (error) {
    errors.value = error?.response?.data?.errors;
    notify.error(error.response.data.message);
  }
}

getDiscount();
</script>
