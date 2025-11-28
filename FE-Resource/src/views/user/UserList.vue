<template>
  <div>
    <h2>Danh sách người dùng</h2>
    <ul>
      <li v-for="u in users" :key="u.id">{{ u.full_name }} - {{ u.email }}</li>
    </ul>
    <button @click="logout()">Logout</button>
  </div>
</template>

<script setup lang="ts">
    import { ref, onMounted } from 'vue'
    import authApi from '@/api/axios';
    import router from '@/router';

    const users = ref([])
    async function logout() {
        try {
            await authApi.post('user/logout')
            localStorage.removeItem('token')
            alert('đăng xuất thành công!')
            router.push('/')
        } catch (error) {
            console.error('Logout failed:', error)
        }
    }

    onMounted(async () => {
        const res = await authApi.get('/user/list')
        users.value = res.data.list
        console.log(res);
    })
</script>
