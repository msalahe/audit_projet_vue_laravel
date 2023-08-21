

<template>
    <div class="container">
        <div class="row mx-0">
            <div class="col-xl-4 col-md-6 mx-auto">
                <div class="card border-0">
                    <div class="card-header border-bottom-0 text-center">
                        <img src="/assets/image/logo-w.png" width="100%">

                    </div>
                    <div class="card-body text-center">
                        <h6 class="text-white my-3">Sign-in With</h6>
                        <a href="/auth/google" class="btn btn-login"><i class="fas fa-at fa-3x mb-2"></i>
                            <h6>Shellboxes Account</h6>
                        </a>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>


<script setup>
import { reactive, onMounted, ref, inject } from "vue";
import { useAuthStore } from '@/stores/authuser'
import { useRouter, useRoute } from 'vue-router'

const route = useRoute()

const userStore = useAuthStore()

const toast = inject('toast');
const state = reactive({
    data: []

});


onMounted(async () => {
    if (route.query != null && route.query.e == 1) {
        toast.error('Login error')
    }
});



</script>
<style scoped>
.card {
    background-color: var(--popupBg);
    border-radius: 12px !important;
    box-shadow: 0 0 10px rgba(104, 85, 224, 0.2);
    padding: 20px;

}

.card-header {
    margin: auto;
    background-color: inherit;

}

.btn-login {
    border: solid 0.5px #bbb;
    padding: 12px;
    color: white;
    transition: 0.4s;
}

.btn-login:hover {
    background-color: var(--navActive);
    color: var(--blackColor);
}

.container {

    display: flex;
    justify-content: center;
    align-items: center;
    height: 97vh;
    /* Sets the height of the body to the full viewport height */
}
</style>
