<script setup>
import { computed, reactive, ref, watch } from 'vue'
// ref
const count = ref(0)
watch(count, (newVal, oldVal) => {
  console.log('Changed:', oldVal, '=>', newVal)
})
function increase() {
  count.value++
}
// reactive
const user = reactive({
  name: 'Tru',
  age: '27',
  address: 'HN',
})

function updateCity() {
    user.address = 'Ha Noi'
}
// v-bind
const input = ref('')

// computed() add to cart
const listProduct = reactive([
  {
    id:1,
    name:'áo phông',
    price: 100000,
    quantity : 2
  },
  {
    id:2,
    name:'áo sơ mi',
    price: 230000,
    quantity : 6
  },
  {
    id:3,
    name:'Quần short',
    price: 150000,
    quantity : 4
  }
])
const cart = reactive(
    {
      item:[
        {
          id:null,
          name:null,
          price:null,
          quantity:null,
        }
      ],
      totalQuantity:0
    }
  );
const totalPrice = computed(() =>
  cart.item.reduce((sum, p) => sum + p.price * p.quantity, 0)
);

function addToCart(product) {
  const exists = cart.item.find(p => p.id === product.id);
  const productAdd = listProduct.find(p => p.id === product.id);
  
  if(productAdd) {
    productAdd.quantity--
  }
  if(productAdd.quantity <= 0 ) {
    alert('hết hàng')
    return;
  }

  if(exists) {
    exists.quantity++
    cart.totalQuantity++
  }else {
    cart.item.push({
      id: product.id,
      name: product.name,
      price: product.price,
      quantity: 1,
    });
    cart.quantity++
  }
}

const age = ref(18)
const msg = computed(() => {
  return age.value >=20 ?'quá tuổi':'dưới 20'
})

function updateAge() {
  age.value +=1
}
</script>

<template>
  <div>
    <div>
        <h3>--Danh sách sản phẩm--</h3>
        <div class="list">
            <div class="p-2" v-for="item in listProduct" :key="item.id">
                <span class="border">tên sản phẩm: {{ item.name}}</span><br>
                <span>Giá: {{ item.price}}</span><br>
                <span>số lượng: {{ item.quantity}}</span><br>
                <button class="border" @click="addToCart(item)">Add to cart</button>

            </div>
        </div>

        <h3>--Cart--</h3>
        <label for="">sản phẩm :</label>
        <div class="" v-for = "product in cart.item" :key="product.id">
          {{ product.name }} x {{ product.quantity}}
        </div>
        <div class=""><span>Tổng sản phẩm : {{ cart.totalQuantity }}</span></div>
        <div class=""><span>Tổng tiền :{{ totalPrice }}</span></div>

        <h1>tuổi : {{ age }}</h1>
        <h1>{{ msg }}</h1>
    </div>

    <div class="mt-2">
      <button @click="updateAge">updateAge()</button>
    </div>

  </div> 
</template>

<style scoped>

</style>
