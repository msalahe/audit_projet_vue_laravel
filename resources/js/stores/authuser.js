import { defineStore } from 'pinia';
import { reactive,readonly } from 'vue';
import router from '../routes';

export const useAuthStore = defineStore('auth', () => {
    const data = reactive({ authUser: null , role:""})

    async function login(email) {
        let login_error = false;
        const email_var = { email: email };
        await axios.get('/sanctum/csrf-cookie')
        const user = await axios.post("/login", email_var).then(user => {
            data.authUser = user.data.user
            alert(data);
            setTimeout(function () {
                router.push('/')
            }, 2000);
        }).catch(function (error) {
            //console.log(error.response.data)
            login_error = true
        })

        return login_error
    }
    async function setRole(dt){
        data.role = dt
    }
    async function logout() {
        await axios.get("/logout").then(data => {
            localStorage.removeItem('token');
            data.authUser = null
            router.push('/login')
        }).catch(function (error) {
            console.log(error.response.data)
        })
    }

    return {
        data,
        login,
        logout,
        setRole
    }
},{
    persist : true
});
