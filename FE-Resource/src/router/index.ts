import { createRouter, createWebHistory } from 'vue-router'
import DashboardView from '@/views/dashboard/DashboardView.vue'
import ReactivityComponent from '@/components/ReactivityComponent.vue'
import App from '@/App.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashbord',
      component: DashboardView,
      children: [
          {
            path: '/reactivity',
            name: 'reactivity',
            component: ReactivityComponent,
          },
      ]
    },
    
    // {
    //   path: '/',
    //   name: 'login',
    //   component: LoginForm,
    // },
    // {
    //   path: '/dashboard',
    //   name: 'dashboard',
    //   component: DashboardView,
    //   meta: { requiresAuth: true }
    // },

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
    next('dashboard')
  } else {
    next()
  }
})
export default router
