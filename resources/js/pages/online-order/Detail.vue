<template>
  <q-page>
    <div class="q-pa-md" style="text-align: center">
      <q-card class="my-card bg-white q-pa-md">
        <div class="row justify-center">
          <div class="col">
            <h4>Chi tiết đơn hàng</h4>
            <div>
              <strong>Thuộc cửa hàng:</strong> {{ onlineOrder.store_id }}
            </div>
            <div><strong>Loại:</strong> {{ onlineOrder.type }}</div>
            <div>
              <strong>Hình thức thanh toán:</strong>
              {{ onlineOrder.payment_type }}
            </div>
            <div><strong>Tổng tiền:</strong> {{ onlineOrder.total }} VND</div>
            <div>
              <strong>Thời gian mua:</strong>
              {{ formatDate(onlineOrder.created_at) }}
            </div>
            <div>
              <strong>Khách hàng:</strong> {{ user.name }} - {{ user.email }}
            </div>
            <div>
              <strong>Địa chỉ:</strong>
              {{ onlineOrder.online_order.customer_address }}
            </div>
            <div>
              <strong>Liên hệ:</strong>
              {{ onlineOrder.online_order.customer_phone }}
            </div>
            <h5>Các sản phẩm</h5>
            <div v-for="product in onlineOrder.products" :key="product.id">
              <div><strong>Tên sản phẩm:</strong> {{ product.name }}</div>
              <div><strong>Số lượng:</strong> {{ product.pivot.qty }}</div>
            </div>
          </div>
        </div>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useOnlineOrderStore } from "@/store/online-order";

const router = useRouter();
const onlineOrderStore = useOnlineOrderStore();
const onlineOrder = ref({});
const user = ref({});

const fetchDetailOnlineOrder = async (orderId) => {
  try {
    const response = await onlineOrderStore.getDetailOnlineOrder(orderId);
    onlineOrder.value = response.data;
    user.value = response.data.online_order.user;
  } catch (error) {
    console.error("Error fetching online order details:", error);
  }
};

onMounted(() => {
  const orderId = router.currentRoute.value.params.id;
  fetchDetailOnlineOrder(orderId);
});

const formatDate = (dateString) => {
  const options = { year: "numeric", month: "numeric", day: "numeric" };
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", options);
};
</script>
