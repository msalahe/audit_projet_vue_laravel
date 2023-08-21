<template>
    <main class="row mx-0 pt-5">
      <div class="row mx-0 mb-2 text-end">
        <div class="col-xl-4  ms-auto mb-2">
            <button class="btn btn-light" @click="auditStore.showBps()">New BPs</button>

        </div>
        <div class="row mx-0">
        <div class="col-xl-12 mb-2">
          <newBp v-if="auditStore.data.showBp"></newBp>

        </div>
        </div>
    </div>
      <div class="row mx-0">
        <div class="col-xl-5 mb-2">
          <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-light " :class="{'active':bpScope.scope=='All BPs'}" @click="bpScope.scope='All BPs'">All BPs</button>
          <button type="button" class="btn btn-light" :class="{'active':bpScope.scope=='My BPs'}" @click="bpScope.scope='My BPs'">My BPs</button>
           </div>
        </div>
        <div class="col-xl-7">
            <div class="row mx-0">
             <div class="col-xl-4">
              <select class="form-select">
                <option selected disabled>Status</option>
              </select>
             </div>
             <div class="col-xl-4">
              <select class="form-select">
                <option selected disabled>Auditor</option>
              </select>
             </div>
           
            </div>
        </div>
      </div>
      <div class="row mx-0">
        <div class="py-3 accordion">
          <BpSection   v-for="bp in bps" :key="bp.id" :bp_p="bp" :status="status"/>
      </div>
      </div>
       
    </main>
</template>

<script setup>
  import BpSection from "@/components/projet/BpSection.vue";
  import { ref, onMounted, reactive, computed, watch, inject } from 'vue';
  import newBp from "@/components/projet/newBp.vue";
  import { useAuditStore } from '@/stores/audit'
  import { useRoute } from 'vue-router';

  const auditStore = useAuditStore();

   const route = useRoute();
   const postId = route.params.id;
   const getProjetBps = async (page = 1) =>{
    if(page == 1){
      const response = await axios.get(`/audits/${postId}/bps`)
 
     bps.value = response.data;

    }else{
      const response = await axios.get(`/audits/${postId}/bps/me`)
 
      bps.value = response.data;
    }
       
  }

   const bps = ref();
    const bpScope = reactive({
      scope : "All BPs"
    })
    onMounted(async () => {
    await getProjetBps();

});
watch(
  [bpScope],
  ([newbpScope]) => {
    if(newbpScope.scope == "My BPs"){
      getProjetBps(2);

    }
    getProjetBps();
  }
);
</script>

<style scoped>
.btn-light{
  border-color: var(--blackBorder);
}
.active{
  background-color: var(--navActive);
}
</style>