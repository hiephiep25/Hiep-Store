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
                                (val) => !!val.trim() || 'Please enter email!',
                                (val) =>
                                    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ||
                                    'Email is invalid',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="authStore.user.name" label="Name" :rules="[
                                (val) => !!val.trim() || 'Please enter name!',
                                (val) =>
                                    (val && val.length <= 256) ||
                                    'Name can not have more than 255 characters',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'MANAGER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="storeNameModel"
                                label="Store name" :rules="[
                                    (val) => !!val.trim() || 'Please enter store name!',
                                    (val) =>
                                        (val && val.length <= 256) ||
                                        'Store name can not have more than 255 characters',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'MANAGER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="storeAddressModel"
                                label="Store address" :rules="[
                                    (val) => !!val.trim() || 'Please enter store address!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'MANAGER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="storeContactModel"
                                label="Store contact" :rules="[
                                    (val) => !!val.trim() || 'Please enter store contact!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyNameModel"
                                label="Company name" :rules="[
                                    (val) => !!val.trim() || 'Please enter company name!',
                                    (val) =>
                                        (val && val.length <= 256) ||
                                        'Company name can not have more than 255 characters',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyAddressModel"
                                label="Company address" :rules="[
                                    (val) => !!val.trim() || 'Please enter company address!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'SUPPLIER'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="companyContactModel"
                                label="Company contact" :rules="[
                                    (val) => !!val.trim() || 'Please enter company contact!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'STAFF'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="phoneModel" label="Phone" :rules="[
                                (val) => !!val.trim() || 'Please enter phone!',
                                (val) =>
                                    val === null ||
                                    val === '' ||
                                    /^[0-9]*$/.test(val) ||
                                    'Phone is invalid',
                            ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'STAFF'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined dense v-model="addressModel" label="Address"
                                :rules="[
                                    (val) => !!val.trim() || 'Please enter address!',
                                ]" />
                        </div>
                    </div>
                    <div class="row justify-center" v-if="authStore.user.role === 'STAFF'">
                        <div class="col-12 col-md-6">
                            <q-input class="q-ma-md" outlined type="date" dense v-model="dobModel"
                                label="Birthday" :rules="[
                                    (val) => !!val.trim() || 'Please enter birthday',
                                    (val) =>
                                        new Date(val) <= new Date() ||
                                        'Birthday is invalid',
                                ]" />
                        </div>
                    </div>
                    <div class="column items-center">
                        <q-btn class="q-ma-md col-3" type="submit" no-caps color="primary" :disable="loading"
                            :loading="loading" label="Update" />
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

const storeNameModel = ref(authStore.manager?.store_name || "");
const storeAddressModel = ref(authStore.manager?.store_address || "");
const storeContactModel = ref(authStore.manager?.store_contact || "");
const companyNameModel = ref(authStore.supplier?.company_name || "");
const companyAddressModel = ref(authStore.supplier?.company_address || "");
const companyContactModel = ref(authStore.supplier?.company_contact || "");

const phoneModel = ref(authStore.staff?.phone || "");
const addressModel = ref(authStore.staff?.address || "");
const dobModel = ref(authStore.staff?.dob || "");

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
        if (file.value) {
            formData.append('avatar', file.value);
        }
        formData.append('role', authStore.user.role);
        if (authStore.user.role == 'MANAGER') {
            formData.append('store_name', storeNameModel.value);
            formData.append('store_address', storeContactModel.value);
            formData.append('store_contact', storeAddressModel.value);
        }
        if (authStore.user.role == 'SUPPLIER') {
            formData.append('company_name', companyNameModel.value);
            formData.append('company_address', companyAddressModel.value);
            formData.append('company_contact', companyContactModel.value);
        }
        if (authStore.user.role == 'STAFF') {
            formData.append('phone', phoneModel.value);
            formData.append('address', addressModel.value);
            formData.append('dob', dobModel.value);
        }
        await authStore.updateProfile(formData);
        errors.value = {};
        notify.success('Update profile successfully');
        window.location.reload();
    } catch (error) {
        errors.value = error?.response?.data?.errors
        notify.error(error.response.data.message);
    }
}

watch(() => {
    storeNameModel.value = authStore.manager?.store_name || "";
    storeContactModel.value = authStore.manager?.store_contact || "";
    storeAddressModel.value = authStore.manager?.store_address || "";

    companyNameModel.value = authStore.supplier?.company_name || "";
    companyContactModel.value = authStore.supplier?.company_contact || "";
    companyAddressModel.value = authStore.supplier?.company_address || "";

    phoneModel.value = authStore.staff?.phone || "";
    addressModel.value = authStore.staff?.address || "";
    dobModel.value = authStore.staff?.dob || "";
}, { immediate: true });
</script>
