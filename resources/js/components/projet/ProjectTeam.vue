<template>
    <main class="row mx-0 pb-5">
        <div class="row mx-0 mb-2 text-end">
            <div class="col-xl-4 text-end ms-auto my-4">
                <button class="btn btn-light" @click="auditStore.data.projet.team.unshift({ full_name: '',id:'', role: {name : '',id:''} })">New
                    User</button>

            </div>
        </div>
        <div class="col-xl-10 mx-auto">
            <div class="row mx-0 d-xl-flex d-none">
                <div class="col-xl-5 mb-2">
                    <label class="col-form-label">Full Name:</label>
                </div>
                <div class="col-xl-4 mb-2">
                    <label class="col-form-label">Role:</label>
                </div>
            </div>
            <div class="row mx-0" v-for="user in auditStore.data.projet.team" :key="user.role.name">
                <div class="col-xl-5 mb-2">
                        
                        <AutoComplete  v-model="user.full_name" :field="'full_name'"   :suggestions="filteredBrands" @complete="searchBrand($event,user)" @select="alert(user.full_name)"
                        :placeholder="user.full_name ? user.full_name : ''" />
                </div>
                <div class="col-xl-4 mb-2">
                    <select class="form-select" :value="user.role.id" @change="user.role.id = $event.target.value">
                        <option selected disabled>Role</option>

                        <option v-for="(role, index) in roles" :key="index" :value="role.id"> {{ role.name }}</option>
                    </select>
                </div>
                <div class="col-xl-3 mb-2">
                    <i class="fas fa-save text-secondary" @click="save(user)" style="margin-right: 10%;"></i>
                    <i class="fas fa-trash text-danger" @click="deleteUser(user)"></i>

                </div>
            </div>

            
        </div>


    </main>
    <deleteForm v-if="pageData.delete" v-on:close="closeModalDelete"></deleteForm>
</template>

<script setup >
import { onMounted, reactive, ref, inject,watchEffect  } from 'vue';
import { useRoute } from 'vue-router';
import deleteForm from '@/components/modals/project/deleteteam.vue'
import AutoComplete from 'primevue/autocomplete';
import { useAuditStore } from '@/stores/audit'

const auditStore = useAuditStore()
const route = useRoute();
const postId = route.params.id;
const users = ref();
const pageData = reactive({ delete: false });
const roles = ref();
const user_id = ref();
const usersAll = ref();

const getAllUsers = async () => {
    const response = await axios.get(`/users`)
    usersAll.value = response.data.data;
}

const searchText = ref();

const getUserProjets = async () => {
    const response = await axios.get(`/audits/${postId}/users`)
    users.value = response.data;
    auditStore.data.projet.team = response.data;

}
const deleteUser = (user) => {
    let idUser;
    if(user.full_name.id !=undefined){
        idUser = user.full_name.id;
    }else{
        idUser = user.id;
    }
    user_id.value = idUser;
    pageData.delete = true;
}
onMounted(async () => {
    await getUserProjets();
    await getRoles();
    await getAllUsers();

});
const getRoles = async () => {
    const response = await axios.get(`/roles`)
    roles.value = response.data;
    console.log(roles.value)
}
const save = (user) => {
    let idUser,idRole;
    if(user.full_name.id !=undefined){
        idUser = user.full_name.id;
    }else{
        idUser = user.id;
    }
    idRole = user.role.id;
    let data = {idUser,idRole};

    console.log(data);
}

const closeModalDelete = async (c = false) => {
    if (c) {
        const index = users.value.findIndex(user => user.id === user_id.value);
        if (index !== -1) {
            users.value.splice(index, 1);
        }
        pageData.delete = false

    }
    else {
        pageData.delete = false

    }


}

const brand = ref();
const filteredBrands = ref([]);

const searchBrand = (value, user) => {
   
    brand.value = value.query;
    const filteredUser = filteredBrands.value.find(u => u.full_name === brand.value);
    if (filteredUser) {

        user.id = filteredUser.id;
    }
  
};

// Watch the brand value for changes and update the filtered suggestions
watchEffect(() => {
  filteredBrands.value = usersAll.value
    ? usersAll.value
        .filter((user) =>
          user.full_name.toLowerCase().startsWith(brand.value)
        )
        .map(({ id, full_name }) => ( {id,full_name} ))
    : [];
});
</script>

<style scoped>

</style>