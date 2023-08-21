<template>
    <!-- Modal -->
    <div  class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Settings</h4>
            <button type="button" @click="auditStore.toggleIssueModal()" class="btn-close btn-close-white" ></button>
          </div>
          <div class="modal-body p-3">
            <div style="margin-left: 45%;">
            <label class="switch">
             <input type="checkbox" v-model="auditStore.data.save" >
                <span class="slider"></span>
             </label>
            </div>

            </div>
            
             
            


          <div class="modal-footer border-top-0">
            
          </div>
        </div>
      </div>
    </div>
    </template>
<script setup>
  import {useAuditStore} from '@/stores/audit'
  import {ref,watch} from "vue";
   const auditStore = useAuditStore();

</script>

    <style scoped src="@/../css/popup.css"></style>
    <style scoped>
    .form-control,.form-select{
        height: 50px;
    }
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

    </style>
