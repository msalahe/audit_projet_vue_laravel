<template>
    <!-- Modal -->
    <div  class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">New Projet</h4>
            <button type="button" @click="projetStore.toggleIssueModal()" class="btn-close btn-close-white" ></button>
          </div>
          <div class="modal-body p-3">
            <form>
            <div class="row mx-0">
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Projet Name</label>
                <input type="text" class="form-control" id="full-name"
                :class="{ 'is-invalid': errors.value.projet_name && errors.value.projet_name.$invalid }"
                v-model="projetModel.projet_name"  >
                <div class="invalid-feedback" v-if="errors.value.projet_name && errors.value.projet_name.$invalid">
                                {{ errors.value.projet_name.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Client Name</label>
                <input type="email" class="form-control" 
                :class="{ 'is-invalid': errors.value.client_name && errors.value.client_name.$invalid }"
                id="full-name" v-model="projetModel.client_name">
                <div class="invalid-feedback" v-if="errors.value.client_name && errors.value.client_name.$invalid">
                                {{ errors.value.client_name.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
            </div>
            <div class="row mx-0">
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Start Date</label>
                <input type="date" class="form-control" 
                :class="{ 'is-invalid': errors.value.start_date && errors.value.start_date.$invalid }"
                id="full-name" v-model="projetModel.start_date"  />

                <div class="invalid-feedback" v-if="errors.value.start_date && errors.value.start_date.$invalid">
                                {{ errors.value.start_date.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
              <div class="col-xl-6 mb-2">
                <label for="full-name" class="col-form-label">Finish Date</label>
                <input type="date" class="form-control" id="full-name"
                :class="{ 'is-invalid': errors.value.finish_date && errors.value.finish_date.$invalid }"

                v-model="projetModel.finish_date">
                <div class="invalid-feedback" v-if="errors.value.finish_date && errors.value.finish_date.$invalid">
                                {{ errors.value.finish_date.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
            </div>

            <div class="row mx-0">
              <div class="col-xl-12 mb-2">
                <label for="full-name" class="col-form-label">Description</label>
                <textarea rows="8" class="form-control" 
                :class="{ 'is-invalid': errors.value.description && errors.value.description.$invalid }"

                v-model="projetModel.description" ></textarea>
                <div class="invalid-feedback" v-if="errors.value.description && errors.value.description.$invalid">
                                {{ errors.value.description.$silentErrors[0].$message ?? '' }}
                            </div>
              </div>
           
            </div>

            </form>
            </div>
            
             
            


          <div class="modal-footer border-top-0">
            <button type="button"  @click="addProjet" class="btn btn-success mx-1" >Submit</button>
          </div>
        </div>
      </div>
    </div>
    </template>
   <script setup>
   import { ref, onMounted, reactive, computed, watch, inject } from 'vue';
   import {useProjetStore} from '@/stores/projetStore'
   import { useVuelidate } from '@vuelidate/core'
   import { required, requiredIf } from '@vuelidate/validators'
   const projetStore = useProjetStore();
   const emit = defineEmits(['close'])



    const addProjet = async () =>{
      const v$ = useVuelidate(rules, projetModel)
      errors.value = v$.value;
       alert("rese")
      if (!v$.value.$invalid) {
       
        const projet = await axios.post("/audits", projetModel.value).then(res => {
         toast.success('Projet has been  created')
         projetStore.toggleIssueModal();

       }).catch( (error) => {
        toast.error(error.response.data.message)
       })
       }

   }

const projetModel = ref({

    'projet_name': '',
    'client_name': '',
    'start_date': '',
    'finish_date': '',
    'description': '',


})

const errors = reactive({ value: [] })

const rules = {
    projet_name: { required },
    client_name: { required },
    start_date: { required },
    finish_date: { required },
    description: { required },
   
}


   




onMounted(async () => {

});


</script>

    <style scoped src="@/../css/popup.css"></style>
    <style scoped>
    .form-control,.form-select{
        height: 50px;
    }
    </style>
