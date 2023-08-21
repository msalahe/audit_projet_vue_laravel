<template>
    <!-- Modal -->
    <div  class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">New Auditor / BizDev</h4>
            <button type="button" @click="$emit('close')" class="btn-close btn-close-white" ></button>
          </div>
          <div class="modal-body p-3">
            <form>
            <div class="row mx-0">
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Full Name:</label>
                <input type="text" class="form-control" id="full-name"
                :class="{ 'is-invalid': errors.value.full_name && errors.value.full_name.$invalid }"
                v-model="userModel.full_name"  >

                <div class="invalid-feedback" v-if="errors.value.full_name && errors.value.full_name.$invalid">
                                {{ errors.value.full_name.$silentErrors[0].$message ?? '' }}
                            </div>

              </div>
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Email:</label>
                <input type="email" class="form-control"
                :class="{ 'is-invalid': errors.value.email && errors.value.email.$invalid }"
                id="full-name" v-model="userModel.email">

                <div class="invalid-feedback" v-if="errors.value.email && errors.value.email.$invalid">
                                {{ errors.value.email.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
            </div>
            <div class="row mx-0">
              <div class="col-xl-6 mb-6">
                <label for="full-name" class="col-form-label"> Skills
                        <font-awesome-icon :icon="['fas', 'square-plus']" style=""
                            @click="userModel.skills.push({ skill: '', percentage: '' })" />
                          </label>
                            <div class="input-group flex-nowrap my-2" v-for="(ss, ind) in userModel.skills" :key="ind">
                        <select class="form-control" 
                        :class="{ 'is-invalid': errors.value.skills && errors.value.skills.$invalid }"
                        v-model="userModel.skills[ind].skill">
                            <option v-for="(s, i) in skills.data" :key="i" :value="s.name"
                                t='v-if="!userModel.skills.some(skill => skill.skill === s.id)"'>
                                <span>
                                    {{ s.name }}
                                </span>
                            </option>
                        </select>
                        <div class="">
                            <input type="number" class="form-control" v-model="userModel.skills[ind].percentage"
                                placeholder="%" aria-label="" aria-describedby="addon-wrapping" min="0" max="100" style="margin-left: 3%;">
                        </div>
                        <div class="d-flex justify-content-center align-items-center ml-1" style="padding-left: 2%;"
                            @click="userModel.skills.splice(ind, 1)">
                            <font-awesome-icon :icon="['far', 'trash-can']" />
                        </div>
                    <br>
                        <div v-if="errors.value.skills && errors.value.skills.$invalid">
                                {{ errors.value.skills.$each.$response.$errors[ind].$message ?? '' }}
                            </div>
                        
                    </div>
         
                </div>
              <div class="col-xl-6 mb-2">
                <label for="role" class="col-form-label">Role:</label>
                <select class="form-select" 
                :class="{ 'is-invalid': errors.value.role && errors.value.role.$invalid }"

                id="role" v-model="userModel.role">
                  <option selected disabled>Role</option>
                  <option v-for="(role, i) in roles.data" :key="i" v-bind:value="role.id">
                                {{ role.name }}
                            </option>
                </select>

                <div class="invalid-feedback" v-if="errors.value.role && errors.value.role.$invalid">
                                {{ errors.value.role.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>

            </div>

            <div class="row mx-0">

                <label for="" class="label">Social links
                            <font-awesome-icon :icon="['fas', 'square-plus']"
                                @click="userModel.socialLinks.push({ name: null, link: null })" style="float : right" />

                        </label>
                        <div class="input-group flex-nowrap my-2" v-for="(rr, ind) in userModel.socialLinks" :key="ind">
                            <input type="text" class="form-control mr-2" v-model="userModel.socialLinks[ind].link"
                                placeholder="Link" aria-label="" aria-describedby="addon-wrapping">
                            <div class="input-group-append">
                                <select class="form-control" v-model="userModel.socialLinks[ind].name" style="margin-left: 3%;">
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
                                <font-awesome-icon :icon="['far', 'trash-can']"  />
                            </div>
                        </div>


            </div>
            </form>
          </div>
          <div class="modal-footer border-top-0">
            <button type="button"  @click="AddUser" class="btn btn-success mx-1" >Submit</button>
          </div>
        </div>
      </div>
    </div>
    </template>
   <script setup>
   import { useVuelidate } from '@vuelidate/core'
   import { required, numeric, minLength, maxValue } from '@vuelidate/validators'

   import { ref, onMounted, reactive, computed, watch, inject } from 'vue';
   import { VueFinalModal } from 'vue-final-modal'
 
   import { helpers } from '@vuelidate/validators'

   import modal from '@/components/modal.vue'
   import rs from '@/config/rs.js'

  

   const toast = inject('toast');
   const props = defineProps({
    user: Object
   });
   const emit = defineEmits(['close'])
    const AddUser = async () =>{
    
    errors.value = $v.value
    console.log(errors.value.skills.$each.$response.$errors[0]);
    if (!$v.value.$invalid) {
    console.log(userModel.value);
    const user = await axios.post("/users/" + (props.user?.id ?? ''), userModel.value).then(user => {
    toast.success('User has been '+(props.user!= null  ? 'updated' : 'created'))
    emit('close', user.data.user)
    }).catch(function (error) {
    console.log(error)
    toast.error(error.response.data.message)
    })
  }
   }
const roles = reactive({ data: [] })
const skills = reactive({ data: [] })

const userModel = ref({

    'full_name': '',
    'email': '',
    'role': '',
    'skills': [{ skill: '', percentage: '' }],
    //'percentage': [],
    'socialLinks': [{ name: '', link: null }]

})

const errors = reactive({ value: [] })

const rules = {
  full_name: { required },
  email: { required },
  role: { required },
  skills: {
    required,
    $each: helpers.forEach({
      skill: {
        required
      },
      percentage : {
        required
      }
    }),
  },
};




const getRoles = async () => {
    const response = await axios.get("/roles")
    roles.data = response.data;
}

const getskills = async () => {
    const response = await axios.get("/skills")
    skills.data = response.data;
}
let $v;
onMounted(async () => {
    await getRoles()
    await getskills()
    $v = useVuelidate(rules, userModel)
    
});


</script>

    <style scoped src="@/../css/popup.css"></style>
    <style scoped>
    .form-control,.form-select{
        height: 50px;
    }
    </style>
