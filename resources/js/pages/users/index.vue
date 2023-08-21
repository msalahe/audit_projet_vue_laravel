<script setup>
import { onMounted, reactive, ref, inject } from 'vue';

import Paginate from "vuejs-paginate-next";

import create from '@/components/modals/users/form.vue'
import edit from '@/components/modals/users/edit.vue'
import deleteForm from '@/components/modals/delete.vue'
const toast = inject('toast');


const usersData = reactive({ value: [] })
const lastPage = ref()

const pageData = reactive({ create: false, user: null, delete: false, edit : false})

const closeModalCreate = (u = null) => {
    pageData.create = false
    if (u != null) {
        const userIndex = usersData.value.data.findIndex(user => user.id === u.id)
        userIndex !== -1 ? usersData.value.data.splice(userIndex, 1, u) : usersData.value.data.push(u)

    }
    pageData.user = null

}

const closeModalEdit = (u = false) => {
    pageData.edit = false
    if (u != null) {
        const userIndex = usersData.value.data.findIndex(user => user.id === u.id)
        userIndex !== -1 ? usersData.value.data.splice(userIndex, 1, u) : usersData.value.data.push(u)

    }
    pageData.user = null
}

const closeModalDelete = async (c = false) => {
    if (c) {
        const response = await axios.delete(`/users/${usersData.value.data[pageData.user].id}`)
            .then(user => {
                toast.success('User has been delete')
                usersData.value.data.splice(pageData.user, 1)
                pageData.delete = false

            }).catch(function (error) {
                toast.error(error.response.data.message)
            })
    }
    else {
        pageData.delete = false

    }
    pageData.user = null

}

const deleteUser = (i) => {
    pageData.delete = true
    pageData.user = i
}
const editUser = (u) => {
    console.log(u)
    pageData.edit = true
    pageData.user = u
}


const getUsers = async (page = 1) => {
    const response = await axios.get(`/users?page=${page}`)
    usersData.value = response.data;
    console.log(usersData);

}

onMounted(async () => {
    await getUsers()

});

const clickCallback = (pageNum) => {
    getUsers(pageNum);
}

</script>

<template>
    <main>
        <div class="row mt-5 m-0">
            <div class="col-xl-8 m-auto">
                <div class="row mx-0 mb-2">
                <h2 class="mb-2 col-xl-8 col-md-6 text-white">Users</h2>
                      <div class="mb-2 col-xl-4 text-end">  <button class="btn btn-light waves-effect fnt" @click="pageData.create = true">New</button></div>
                 </div>
                <div class="container my-3">

                    <table class="table text-center" role="table">
                        <thead>
                        <tr>
                            <th scope="col" >Full Name</th>
                            <th scope="col">Role</th>
                            <th scope="col" >Email</th>
                            <th scope="col">Skills</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, i) in usersData.value.data" :key="i">
                            <td data-label="Full Name"><a>{{ user.full_name }}</a></td>
                            <td data-label="Role"> {{ user.role?.name ?? ''}}</td>
                            <td data-label="Email"> {{ user.email }}</td>
                            <td data-label="Skills">
                                <span v-for="(skill, i) in user.skills" :key="i"  class="badge bg-sec mx-1">
                                    {{ skill.name }} {{ }}
                        </span>
                            </td>
                            <td data-label="Actions">
                                <router-link :to="`/users/${user.id}`"><i class="far fa-clipboard"></i></router-link>

                                <i class="fas fa-edit mb-2" @click="editUser(user)"></i>
                                <i class="fas fa-trash text-danger mb-2" @click="deleteUser(i)"></i>
                            </td>

                        </tr>


                        </tbody>
                    </table>
                    </div>
                    </div>

                    </div>
                    </main>

                    <create v-if="pageData.create" v-on:close="pageData.create=false"></create>
                    <edit v-if="pageData.edit" v-on:close="closeModalEdit" :user="pageData.user"></edit>
                    <deleteForm v-if="pageData.delete" v-on:close="closeModalDelete"></deleteForm>


</template>



<style scoped src="@/../css/table.css"></style>
