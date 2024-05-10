<template>
    <q-page class="q-pa-md">
        <q-card>
            <q-card-section class="align-self-center">
                <q-form @submit="updateProfile">
                    <div class="bg-transparent row column items-center full-height full-width justify-center">
                        <q-avatar size="160px">
                            <img :src="imageSrc ?? ''" alt="" />
                        </q-avatar>
                        <q-file v-model="file" label="Avatar" accept=".jpg, .png, .jpeg" :max-files="1" clearable outlined
                            dense bottom-slots @clear="file = null">
                            <template v-slot:append>
                                <q-icon name="attach_file" />
                            </template>
                        </q-file>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="authStore.user.email" label="Email" :rules="[
                                (val) => !!val.trim() || 'Email không được bỏ trống!',
                                (val) =>
                                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ||
                                    'Email không hợp lệ',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="authStore.user.name" label="Tên" :rules="[
                                (val) => !!val.trim() || 'Tên không được bỏ trống!',
                                (val) =>
                                    (val && val.length <= 256) ||
                                    'Tên không được có nhiều hơn 256 kí tự',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="authStore.user.phone" label="Số điện thoại" :rules="[
                                (val) => !!val.trim() || 'Số điện thoại không được bỏ trống!',
                                (val) =>
                                    val === null ||
                                    val === '' ||
                                    /^[0-9]*$/.test(val) ||
                                    'Số điện thoại không hợp lệ',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="authStore.user.address" label="Địa chỉ"
                                :rules="[
                                    (val) => !!val.trim() || 'Địa chỉ không được bỏ trống!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined type="date" dense v-model="authStore.user.dob"
                                label="Ngày sinh" :rules="[
                                    (val) => !!val.trim() || 'Ngày sinh không được bỏ trống',
                                    (val) =>
                                        new Date(val) <= new Date() ||
                                        'Ngày sinh không hợp lệ',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyNameModel"
                                label="Tên công ty" :rules="[
                                    (val) => !!val.trim() || 'Tên công ty không được bỏ trống!',
                                    (val) =>
                                        (val && val.length <= 256) ||
                                        'Tên công ty không được có nhiều hơn 256 kí tự',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyAddressModel"
                                label="Địa chỉ công ty" :rules="[
                                    (val) => !!val.trim() || 'Địa chỉ công ty không được bỏ trống!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyContactModel"
                                label="Liên hệ của công ty" :rules="[
                                    (val) => !!val.trim() || 'Liên hệ của công ty không được bỏ trống!',
                                ]" />
                        </div>
                    </div>
                    <div class="column items-center">
                        <q-btn class="q-ma-md col-3" type="submit" no-caps color="primary" :disable="loading"
                            :loading="loading" label="Cập nhật" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import useNotify from "@/utils/notify";
import { useAuthStore } from "@/store/auth";

const authStore = useAuthStore();
const notify = useNotify();
const errors = ref({});
const file = ref(null);

const companyNameModel = ref(authStore.supplier?.company_name || "");
const companyAddressModel = ref(authStore.supplier?.company_address || "");
const companyContactModel = ref(authStore.supplier?.company_contact || "");

const imageSrc = computed(() => {
    if (file.value) {
        return URL.createObjectURL(file.value);
    }
    return authStore.user.avatar;
});
async function updateProfile() {
    try {
        const formData = new FormData();
        formData.append('id', authStore.user.id);
        formData.append('email', authStore.user.email);
        formData.append('name', authStore.user.name);
        formData.append('phone', authStore.user.phone)
        formData.append('address', authStore.user.address)
        formData.append('dob', authStore.user.dob)
        if (file.value) {
            formData.append('avatar', file.value);
        }
        formData.append('role', authStore.user.role);
        if (authStore.user.role == 'SUPPLIER') {
            formData.append('company_name', companyNameModel.value);
            formData.append('company_address', companyAddressModel.value);
            formData.append('company_contact', companyContactModel.value);
        }
        await authStore.updateProfile(formData);
        errors.value = {};
        notify.success('Thông tin cá nhân được cập nhật thành công');
        window.location.reload();
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

watch(() => {
    companyNameModel.value = authStore.supplier?.company_name || "";
    companyContactModel.value = authStore.supplier?.company_contact || "";
    companyAddressModel.value = authStore.supplier?.company_address || "";
}, { immediate: true });
</script>
