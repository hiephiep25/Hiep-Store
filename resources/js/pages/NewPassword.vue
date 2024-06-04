<template>
    <q-page>
        <div class="row height-inherit justify-center items-center login-page">
            <q-card class="col-xs-10 col-md-4 height-fit">
                <q-card-section class="q-pb-none">
                    <div class="text-h6 text-center">{{ env.VITE_APP_NAME }}</div>
                </q-card-section>
                <q-card-section>
                    <q-form class="q-px-md" @submit="submit()">
                        <div>Mật khẩu mới</div>
                        <q-input class="q-mt-md" outlined v-model="newPasswordForm.password" dense type="password">
                            <template v-slot:prepend>
                                <q-icon name="key" />
                            </template>
                        </q-input>
                        <p class="text-red custom-error" v-if="errors && errors['password']">
                            {{ errors["password"][0] }}
                        </p>
                        <div class="q-pt-md">Xác nhận mật khẩu mới</div>
                        <q-input class="q-mt-md" outlined v-model="newPasswordForm.password_confirm" dense type="password">
                            <template v-slot:prepend>
                                <q-icon name="key" />
                            </template>
                        </q-input>
                        <p class="text-red custom-error" v-if="errors && errors['password']">
                            {{ errors["password"][0] }}
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
                            <q-btn no-caps class="col-12" :loading="isSubmitting" type="submit" color="primary">
                                {{ "Đặt lại mật khẩu" }}
                            </q-btn>
                        </div>
                    </q-form>
                </q-card-section>
            </q-card>
        </div>
    </q-page>
</template>

<script setup>
import { useAuthStore } from '@/store/auth';
import { reactive, ref, watch } from 'vue';
import { storeToRefs } from 'pinia';
import { useRouter, useRoute } from 'vue-router';
import useNotify from "@/utils/notify";
const env = import.meta.env;

const notify = useNotify();

const isSubmitting = ref(false);
const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const { isAuth } = storeToRefs(authStore);
const { isAdmin } = storeToRefs(authStore);

const newPasswordForm = reactive({
    password: '',
    password_confirm: '',
    token: decodeURIComponent(route.params.token),
});

const submit = async () => {
    try {
        isSubmitting.value = true;
        await authStore.resetPassword(newPasswordForm);
        notify.success('Đặt lại mật khẩu thành công');
        router.push({ name: 'login' });
    } catch (error) {
        console.log(error?.response?.data?.message)
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
