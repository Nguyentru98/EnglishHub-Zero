import { createRouter, createWebHistory } from 'vue-router'
import LoginForm from '@/views/LoginForm.vue'
import UserList from '@/components/UserList.vue'
import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginForm,
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView,
      meta: { requiresAuth: true }
    },
    {
      path: '/user/list',
      name: 'listUser',
      component: UserList,
      meta: { requiresAuth: true }
    },
    
  ],
})
// Kiểm tra token trước khi truy cập route cần xác thực
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    // chưa có token → quay lại login
    next('/')
  } else if (to.path === '/login' && token) {
    // đã login rồi mà vẫn vào login → chuyển về trang chính
    next('/user/list')
  } else {
    next()
  }
})
export default router
