<template>
  <div>Voucher còn hiệu lực</div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
onMounted(
    ()=>{
        console.log('khởi tạo component Voucher')
    }
)
onUnmounted(() => {
  console.log("VoucherComponent đã bị unmount!")
})
</script>
