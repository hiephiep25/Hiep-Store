<template>
    <q-page>
        <div class="row height-inherit justify-center items-center login-page">
            <q-card class="col-xs-10 col-md-4 height-fit">
                <q-card-section class="q-pb-none">
                    <div class="text-h6 text-center">{{ env.VITE_APP_NAME }}</div>
                </q-card-section>
                <q-card-section>
                    <div class="text-center text-red" v-if="invalid">
                        Your email or password is incorrect
                    </div>
                    <q-form class="q-px-md" @submit="login()">
                        <q-input class="q-mt-md" outlined v-model="loginForm.email" dense>
                            <template v-slot:prepend>
                                <q-icon name="email" />
                            </template>
                        </q-input>
                        <p class="text-red custom-error" v-if="errors && errors['email']">
                            {{ errors["email"][0] }}
                        </p>
                        <q-input class="q-mt-md" outlined v-model="loginForm.password" dense type="password">
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
                                {{ "Submit" }}
                            </q-btn>
                        </div>
                        <!-- <div class="row justify-center q-mt-md">
                <router-link :to="{ name: 'forgot-password' }" class="custom-link">{{
                  $t("login.text.forgot_password")
                }}</router-link>
              </div> -->
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
import { useRouter } from 'vue-router';
const env = import.meta.env;

const errors = ref();
const invalid = ref();

const loginForm = reactive({
    email: '',
    password: '',
    remember: true
});

const isSubmitting = ref(false);
const router = useRouter();
const authStore = useAuthStore();
const { isAuth } = storeToRefs(authStore);
const { isAdmin } = storeToRefs(authStore);

const redirect = () => {
    router.push({ name: 'home' });
};

const login = async () => {
    try {
        isSubmitting.value = true;
        errors.value = undefined;
        await authStore.login(loginForm);
        redirect();
    } catch (error) {
        console.log(error);
        if (error?.response?.data.status === 422) {
            errors.value = error?.response?.data?.errors;
        } else {
            invalid.value = true;
        }
    } finally {
        isSubmitting.value = false;
    }
};

watch(
    isAuth,
    (val) => {
        if (val) {
            redirect();
        }
    },
    { immediate: true }
);
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
