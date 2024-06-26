<template>
  <q-page>
    <div class="row height-inherit justify-center items-center login-page">
      <q-card class="col-xs-10 col-md-4 height-fit">
        <q-card-section class="q-pb-none">
          <div class="text-h6 text-center">{{ env.VITE_APP_NAME }}</div>
        </q-card-section>
        <q-card-section>
          <q-form class="q-px-md" @submit="submit()">
            <q-input
              class="q-mt-md"
              outlined
              v-model="forgotPasswordForm.email"
              dense
            >
              <template v-slot:prepend>
                <q-icon name="email" />
              </template>
            </q-input>
            <p class="text-red custom-error" v-if="errors && errors['email']">
              {{ errors["email"][0] }}
            </p>

            <!-- <q-checkbox
                  class="q-mb-md"
                  size="sm"
                  outlined
                  v-model="remember"
                  val
                  dense
                  label="Remember me!" /> -->
            <div class="row justify-center q-mt-md">
              <q-btn
                no-caps
                class="col-12"
                :loading="isSubmitting"
                type="submit"
                color="primary"
              >
                {{ "Gửi xác nhận" }}
              </q-btn>
            </div>
            <div class="row justify-center q-mt-md">
              <router-link :to="{ name: 'login' }" class="custom-link">{{
                "Đăng nhập"
              }}</router-link>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { useAuthStore } from "@/store/auth";
import { reactive, ref, watch } from "vue";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
const env = import.meta.env;

const errors = ref();
const notify = useNotify();
const forgotPasswordForm = reactive({
  email: "",
});

const isSubmitting = ref(false);
const router = useRouter();
const authStore = useAuthStore();
const { isAuth } = storeToRefs(authStore);
const { isAdmin } = storeToRefs(authStore);

const submit = async () => {
  try {
    isSubmitting.value = true;
    errors.value = undefined;
    await authStore.forgotPassword(forgotPasswordForm);
    notify.success("Thư đã được gửi, hãy kiểm tra email");
  } catch (error) {
    console.log(error?.response?.data?.message);
    notify.error(error?.response?.data?.message);
  } finally {
    isSubmitting.value = false;
  }
};
</script>
<style scoped lang="scss">
.height-inherit {
  min-height: inherit;
}

.height-fit {
  height: fit-content;
}

.custom-link {
  text-decoration: none;
  color: $blue-7;
}

.q-page {
  min-height: 100vh !important;
}
</style>
