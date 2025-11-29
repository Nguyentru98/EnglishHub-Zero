<script setup>
import { computed, onMounted,onUnmounted, reactive, ref, watch, watchEffect } from 'vue'
import VoucherComponent from './VoucherComponent.vue'
// danh sách sản phẩm
const listProduct = reactive([
  {
    id: 1,
    name: 'áo phông',
    price: 100000,
    quantity: 4,
  },
  {
    id: 2,
    name: 'áo sơ mi',
    price: 250000,
    quantity: 3,
  },
  {
    id: 3,
    name: 'áo hodie',
    price: 100000,
    quantity: 7,
  },
  {
    id: 4,
    name: 'quần âu',
    price: 100000,
    quantity: 4,
  },
])
// giỏ hàng - reactive()
const carts = reactive(
  {
    items : [],
    totalQuantity : 0,
  }
)
// tự động tính tổng tiền hàng trong giỏ - computed()
const totalPrice = computed(() => {
  return carts.items.reduce((sum,currentValue) => sum + currentValue.price * currentValue.quantity,0)
})
// tự động serch
const keySearch = ref('')
const filter = computed(
  ()=>{
    const product = listProduct.filter(item=>item.name == keySearch.value)
    console.log(keySearch.value);
    return product;
  }
)
// theo dõi giỏ hàng lưu vào locale storage -  watch()
watch(
  ()=>carts,
  (newItem)=>{
    localStorage.setItem('my-cart',JSON.stringify(newItem))
    console.log('Đã lưu giỏ hàng!',newItem)
  },
  { deep: true }
)
// luôn chạy lần đầu, lần tiếp theo khi biến xảy ra phản ứng
watchEffect(
  ()=>carts.items,
  ()=>{
    const cartLocale = localStorage.getItem('my-cart');
    if(cartLocale) {
      const data = JSON.parse(cartLocale);
      carts.items = data.items;
      carts.totalQuantity = cartLocale.totalQuantity
    }
    
  },
)
// thêm sản phẩm vào giỏ hàng - fn()
function addToCart(id) {
  const product = listProduct.find(pr => id === pr.id)
  const checkExist = carts.items.find(pr => id === pr.id )
  if(checkExist) {
    checkExist.quantity++
    carts.totalQuantity++
    product.quantity--
  }else{
    carts.items.push({
      id:product.id,
      name:product.name,
      price:product.price,
      quantity:1,
    })
    carts.totalQuantity++
    product.quantity--
  }
}
function deleteCart() {
  carts.items = [];
  carts.totalQuantity = 0;
  localStorage.removeItem('my-cart')
}
// ví dụ về life cycle
const timeLeft = ref(20) // 20s
let timerId = null
const expiry = ref(true)

onMounted(() => {
  console.log("Run")
  timerId = setInterval(() => {
    console.log("process...")
    if (timeLeft.value > 0) {
      timeLeft.value--
    } else {
      console.log('hết hạn sử dụng voucher')
      expiry.value = false;
      clearInterval(timerId)
    }
  }, 1000)
})

// trường hợp thoát khỏi component này thì sẽ clearInterval nếu không có onUnmounted thì sang commponent khác sẽ vẫn chạy setInterval() thời gian vẫn được tính
onUnmounted(() => {
  if (timerId) {
    console.log('clean completed')
    clearInterval(timerId)   // tránh memory leak
  } 
})
</script>

<template>
  <div>
    <div class="list_product">
      <h3>Danh sách sản phẩm</h3>
      <div class="flash-sale">
        <p>Khuyến mãi kết thúc trong: {{ Math.floor(timeLeft / 60) }}:{{
            String(timeLeft % 60).padStart(2, '0')
          }}
        </p>
        <VoucherComponent v-if="expiry"/>
      </div>
      Tìm kiếm
      <input type="text" class="border" v-model="keySearch">
      <ul v-if="filter.length">
        <li class="p-2" v-for="product in filter" :key="product.id">
          <span class="p-2">{{ product.name }} - {{ product.price }}đ - sl:{{ product.quantity }}</span>
          <button class="border p-1" @click="addToCart(product.id)">Add+</button>
        </li>
      </ul>
      <ul v-if="filter.length === 0">
        <li class="p-2" v-for="product in listProduct" :key="product.id">
          <span class="p-2">{{ product.name }} - {{ product.price }}đ - sl:{{ product.quantity }}</span>
          <button class="border p-1" @click="addToCart(product.id)">Add+</button>
        </li>
      </ul>
    </div>

    <div class="cart">
      <h3>Cart</h3>
      <ul>
          <li v-for="pr in carts.items" :key="pr.id">
            sp : {{ pr.name }} <span v-if="pr.name">x {{ pr.quantity }}</span>
          </li>
      </ul>

      <div class="total_price">
       Tổng tiền : {{ totalPrice }}
      </div>
      <div class="total_quantity">
       Tổng sản phẩm: {{carts.totalQuantity }}
      </div>

    <div class="">
      <button class="border" @click="deleteCart">Xóa giỏ hàng</button>
    </div>
    </div>
  </div>
</template>

<style scoped>
</style>
