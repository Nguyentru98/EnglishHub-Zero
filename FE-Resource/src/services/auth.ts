import authApi from '@/api/axios'

interface payload {
    username:string,
    password:string
}
export default {
    login(payload:payload) {
        return authApi.post('/user/login',payload)
    }
}