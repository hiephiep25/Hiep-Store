<template>
    <q-page class="q-ma-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form class="q-gutter-md" @submit="updatePassword()">
                    <div class="row justify-center">
                        <div class="col-12">
                            <Input v-model:model-value="form" name="password" type="password" width-common="col-8 q-ml-lg"
                                width-label="col-2" label="New password" :errors="errors" />
                            <Input v-model:model-value="form" name="password_confirmation" type="password"
                                width-common="col-8 q-ml-lg" width-label="col-2" label="New password (for confirmation)"
                                :errors="errors" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <q-btn type="submit" color="primary" label="Change password" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useAuthStore } from "@/store/auth";
import { useRouter } from "vue-router";
import useNotify from "@/utils/notify";
import Input from "../components/common/Input.vue";

const errors = ref({});
const form = reactive({
    password: "",
    password_confirmation: "",
});

const router = useRouter();
const authStore = useAuthStore();
const notify = useNotify();

const updatePassword = async () => {
    try {
        await authStore.changePassword(form);
        errors.value = {};
        notify.success("You have successfully changed your password");
        authStore.useLogout();
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
};
</script>
