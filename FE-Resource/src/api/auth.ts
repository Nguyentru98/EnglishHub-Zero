import authApi from "./axios";

interface RegisterPayload {
    email:string;
    password:string;
    name?:string;
}

export default {
    async register(payload:RegisterPayload) {
        return await authApi.post('user/register', payload)
    } 
}