<template>
    <div  class="modal modal-lg fade show"
    tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" aria-hidden="true" role="dialog"
    style="display:block" >
     <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">


         <div class="modal-body p-3">
            <div class=" m-auto row mx-0 font-size-14" >
                <div class="col-xl-10 mx-auto text-center ">
                  <h4 class="my-5">Do you really want to delete it ?</h4>
                  <div class="row mx-0 mb-4 justify-content-center">
                    <button class="col-xl-2 btn btn-success mx-3" @click="$emit('close',true)">Yes</button>
                    <button class="col-xl-2 btn btn-danger" @click="$emit('close')">No</button>
                  </div>
                </div>
            </div>
         </div>

       </div>
     </div>
   </div>
</template>

<script setup>

</script>

<style scoped src="@/../css/popup.css"></style>
