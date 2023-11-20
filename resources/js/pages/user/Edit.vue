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
                  label="Name"
                  :errors="errors"
                />
                <Input
                  v-model:model-value="form"
                  name="email"
                  type="text"
                  width-common="col-8 q-ml-lg"
                  width-label="col-2"
                  label="Email"
                  :errors="errors"
                />
                <Input
                  v-model:model-value="form"
                  name="password"
                  type="password"
                  width-common="col-8 q-ml-lg"
                  width-label="col-2"
                  label="Password"
                  :errors="errors"
                />
                <SelectBox
                  v-model:model-value="form"
                  name="role"
                  width-common="col-8 q-ml-lg"
                  width-label="col-2"
                  label="Role"
                  :option="UserRole"
                  :errors="errors"
                />
              </div>
            </div>
            <div class="row justify-center">
              <q-btn type="submit" color="primary" label="Edit" />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-page>
  </template>

  <script setup>
  import { reactive, ref } from 'vue';
  import { useUserStore } from '@/store/user';
  import { useRouter, useRoute } from 'vue-router';
  import useNotify from '@/utils/notify';
  import Input from '../../components/common/Input.vue';
  import SelectBox from '../../components/common/SelectBox.vue';

  const UserRole = [
  { label: "ADMIN", value: "ADMIN" },
    { label: "MANAGER", value: "MANAGER" },
    { label: "CUSTOMER", value: "CUSTOMER" },
    { label: "SUPPLIER", value: "SUPPLIER" },
  ];

  const form = reactive({
    name: "",
    email: "",
    password: "",
    role: "",
  });

  const { params } = useRoute();
  const id = params.id;

  const errors = ref({});
  const router = useRouter();
  const userStore = useUserStore();
  const notify = useNotify();

  const getUser = async () => {
    try {
      const user = await userStore.getUser(id);
      form.name = user.name;
      form.email = user.email;
      form.role = user.role;
    } catch (error) {
      throw error;
    }
  };

  async function update() {
    try {
      await userStore.updateUser(id, form);
      errors.value = {};
      notify.success('Edited the data successfully');
      router.push({ name: 'user.index' });
    } catch (error) {
      errors.value = error?.response?.data?.errors
      notify.error(error.response.data.message);
    }
  }

  getUser();
  </script>
