
<template>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Đăng Nhập</h1>
                <p>Chào mừng bạn quay lại</p>
            </div>

            <form @submit.prevent="handleLogin" id="loginForm">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        v-model="email"
                        type="email" 
                        class="form-control" 
                        id="email" 
                        placeholder="Nhập email của bạn"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input 
                        v-model="password"
                        type="password" 
                        class="form-control" 
                        id="password" 
                        placeholder="Nhập mật khẩu"
                        required
                    >
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="remember"
                        >
                        <label class="form-check-label" for="remember">
                            Ghi nhớ tôi
                        </label>
                    </div>
                    <div class="forgot-password">
                        <a href="#forgot">Quên mật khẩu?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">Đăng Nhập</button>
            </form>

            <div class="signup-link">
                Chưa có tài khoản? <a href="#signup">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import authApi from '@/api/axios';
    import router from '@/router';
    import { ref } from 'vue';

    const email = ref('');
    const password = ref('');

    async function handleLogin() {
        try {
            const res = await authApi.post('/user/login',{
                email: email.value,
                password : password.value
            })
            localStorage.setItem('token', res.data.token)
            alert('Đăng nhập thành công!')
            router.push('/user/list')
        } catch (error) {
            console.error('Lỗi đăng nhập:', error.response?.data || error)
            alert('Sai email hoặc mật khẩu!')   
        }
    }

</script>

<style scoped>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            width: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-check {
            margin-bottom: 20px;
        }

        .form-check-input {
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
            margin-left: 8px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>