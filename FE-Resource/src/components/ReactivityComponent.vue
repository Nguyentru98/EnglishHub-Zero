<script setup lang="ts">
import { computed, onMounted, onUnmounted, reactive, ref, watch } from 'vue'
import VoucherComponent from './VoucherComponent.vue'

// === 1. Định nghĩa interface (bắt buộc khi dùng TS) ===
interface Product {
  id: number
  name: string
  price: number
  quantity: number
}

interface CartItem extends Product {
  quantity: number // số lượng trong giỏ
}

// === 2. Danh sách sản phẩm ===
const listProduct = reactive<Product[]>([
  { id: 1, name: 'áo phông', price: 100000, quantity: 4 },
  { id: 2, name: 'áo sơ mi', price: 250000, quantity: 3 },
  { id: 3, name: 'áo hodie', price: 400000, quantity: 7 },
  { id: 4, name: 'quần âu', price: 350000, quantity: 4 },
])

// === 3. Giỏ hàng ===
const carts = reactive<{
  items: CartItem[]
  totalQuantity: number
}>({
  items: [],
  totalQuantity: 0,
})

// === 4. Computed: Tổng tiền ===
const totalPrice = computed(() => {
  return carts.items.reduce((sum, item) => sum + item.price * item.quantity, 0)
})

// === 5. Tìm kiếm sản phẩm ===
const keySearch = ref('')
const filter = computed(() => {
  if (!keySearch.value.trim()) return listProduct
  return listProduct.filter(item =>
    item.name.toLowerCase().includes(keySearch.value.toLowerCase())
  )
})

// === 6. Lưu giỏ hàng vào localStorage (SAI TRONG BẢN GỐC!) ===
watch(
  () => ({ ...carts }), // clone để watch deep chính xác
  (newVal) => {
    localStorage.setItem('my-cart', JSON.stringify(newVal))
    console.log('Đã lưu giỏ hàng!', newVal)
  },
  { deep: true }
)

// === 7. Load giỏ hàng khi khởi động (sửa lỗi watchEffect sai hoàn toàn) ===
onMounted(() => {
  const saved = localStorage.getItem('my-cart')
  if (saved) {
    const data = JSON.parse(saved)
    carts.items = data.items ?? []
    carts.totalQuantity = data.totalQuantity ?? 0
    console.log('Đã khôi phục giỏ hàng từ localStorage')
  }
})

// === 8. Thêm vào giỏ hàng ===
function addToCart(id: number) {
  const product = listProduct.find(p => p.id === id)
  if (!product || product.quantity <= 0) {
    alert('Sản phẩm hết hàng!')
    return
  }

  const existItem = carts.items.find(item => item.id === id)
  if (existItem) {
    existItem.quantity++
  } else {
    carts.items.push({
      id: product.id,
      name: product.name,
      price: product.price,
      quantity: 1,
    })
  }

  carts.totalQuantity++
  product.quantity-- // giảm tồn kho
}

// === 9. Xóa giỏ hàng ===
function deleteCart() {
  carts.items = []
  carts.totalQuantity = 0
  localStorage.removeItem('my-cart')
}

// === 10. Đếm ngược voucher ===
const timeLeft = ref(20)
const expiry = ref(true)
let timerId: number | null = null

onMounted(() => {
  console.log('Component được mount')
  timerId = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--
    } else {
      expiry.value = false
      clearInterval(timerId!)
      timerId = null
      console.log('Voucher đã hết hạn!')
    }
  }, 1000)
})

onUnmounted(() => {
  if (timerId !== null) {
    clearInterval(timerId)
    console.log('Đã dọn dẹp timer – tránh memory leak')
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
