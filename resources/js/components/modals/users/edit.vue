<template>
    <!-- Modal -->
    <div class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Auditor / BizDev</h4>
                    <button type="button" @click="$emit('close')" class="btn-close btn-close-white"></button>
                </div>
                <div class="modal-body p-3">
                    <form>
                        <div class="row mx-0">
                            <div class="col-xl-6 mb-2">
                                <label for="full-name" class="col-form-label">Full Name:</label>
                                <input type="text" class="form-control" id="full-name" v-model="userModel.full_name">
                            </div>
                            <div class="col-xl-6 mb-2">
                                <label for="full-name" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="full-name" v-model="userModel.email">
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-xl-6 mb-2">
                                <label for="full-name" class="col-form-label">Skills
                                    <font-awesome-icon :icon="['fas', 'square-plus']"
                                        @click="userModel.skills.push({ skill: null, percentage: null })" /></label>
                                <div class="input-group flex-nowrap my-2" v-for="(ss, ind) in userModel.skills" :key="ind">
                                    <select class="form-control" v-model="userModel.skills[ind].skill">
                                        <option v-for="(s, i) in skills.data" :key="i" :value="s.name"
                                            t='v-if="!userModel.skills.some(skill => skill.skill === s.id)"'>
                                            <span>
                                                {{ s.name }}
                                            </span>
                                        </option>
                                    </select>
                                    <div class="">
                                        <input type="number" class="form-control" v-model="userModel.skills[ind].percentage" style="margin-left: 2%;"
                                            placeholder="%" aria-label="" aria-describedby="addon-wrapping" min="0"
                                            max="100">
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center ml-1" style="padding-left: 2%;"
                                        @click="userModel.skills.splice(ind, 1)">
                                        <font-awesome-icon :icon="['far', 'trash-can']" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-2">
                                <label for="role" class="col-form-label">Role:</label>
                                <select class="form-select" id="role" v-model="userModel.role">
                                    <option selected disabled>Role</option>
                                    <option v-for="(role, i) in roles.data" :key="i" v-bind:value="role.id">
                                        {{ role.name }}
                                    </option>
                                </select>

                            </div>

                        </div>

                        <div class="row mx-0">

                            <label for="" class="label">Social links
                                <font-awesome-icon :icon="['fas', 'square-plus']"
                                    @click="userModel.socialLinks.push({ name: null, link: null })" style="float: right ;"/>

                            </label>
                            <div class="input-group flex-nowrap my-2" v-for="(rr, ind) in userModel.socialLinks" :key="ind">
                                <input type="text" class="form-control mr-2" v-model="userModel.socialLinks[ind].link"
                                    placeholder="Link" aria-label="" aria-describedby="addon-wrapping">
                                <div class="input-group-append">
                                    <select class="form-control" v-model="userModel.socialLinks[ind].name" style="margin-left: 2%;">
                                        <option v-for="(r, i) in rs" :key="i" :value="r[0]">
                                            <span>
                                                <font-awesome-icon :icon="r[1]" />
                                            </span>
                                            <span v-html="r[0]"></span>
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-center align-items-center ml-1" style="padding-left: 2%;"
                                    @click="userModel.socialLinks.splice(ind, 1)">
                                    <font-awesome-icon :icon="['far', 'trash-can']" />
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" @click="AddUser" class="btn bg-sec text-white">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, reactive, computed, watch, inject } from 'vue';
import { VueFinalModal } from 'vue-final-modal'
import modal from '@/components/modal.vue'
import rs from '@/config/rs.js'
const emit = defineEmits(['close'])
const toast = inject('toast');
const props = defineProps({
    user: Object
});
const AddUser = async () => {
    const user = await axios.post("/users/" + props.user.id , userModel.value).then(user => {
        toast.success('User has been updated')
        emit('close', user.data.user)

    }).catch(function (error) {
        console.log(error)
        toast.error(error.response.data.message)
    })
}
const roles = reactive({ data: [] })
const skills = reactive({ data: [] })

const userModel = ref({
            'full_name': props.user.full_name,
            'email': props.user.email,
            'role': props.user.role?.id ?? null,
            'skills': props.user.skills.map(skill => {
                return { id: skill.id, skill: skill.name, percentage: skill.pivot.level };
            }),
            'socialLinks': props.user.socialLinks
        })

const getRoles = async () => {
    const response = await axios.get("/roles")
    roles.data = response.data;
}

const getskills = async () => {
    const response = await axios.get("/skills")
    skills.data = response.data;
}
onMounted(async () => {
    await getRoles()
    await getskills()

});

const fillEdit = () => {

        const u = props.user
        userModel.value = {
            'full_name': u.full_name,
            'email': u.email,
            'role': u.role.id,
            'skills': u.skills.map(skill => {
                return { id: skill.id, skill: skill.name, percentage: skill.pivot.level };
            }),
            'socialLinks': u.socialLinks
        }

}

</script>

<style scoped src="@/../css/popup.css"></style>
<style scoped>
.form-control,
.form-select {
    height: 50px;
}
</style>
