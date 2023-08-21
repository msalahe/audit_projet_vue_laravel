<template>
    <main class="row mx-0 pt-5">
      <div class="row mx-0 mb-2 text-end">
        <div class="col-xl-4  ms-auto mb-2">
            <button class="btn btn-light" @click="issueStore.showIssue()">New Issue</button>

        </div>
        <div class="row mx-0">
        <div class="col-xl-12 mb-2">
          <newIssue v-if="issueStore.data.showIssue" ></newIssue>

        </div>
        </div>

    </div>
      <div class="row mx-0">
        <div class="col-xl-5 mb-2">
          <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-light " :class="{'active':IssueScope.scope=='All Issues'}" @click="IssueScope.scope='All Issues'">All Issues</button>
          <button type="button" class="btn btn-light" :class="{'active':IssueScope.scope=='My Issues'}" @click="IssueScope.scope='My Issues'">My Issues</button>
          <button type="button" class="btn btn-light" :class="{'active':IssueScope.scope=='Stats'}" @click="IssueScope.scope='Stats'">Stats</button>
           </div>
        </div>
        <div class="col-xl-7"  v-if="drapo" >
            <div class="row mx-0">
             <div class="col-xl-4">
              <select class="form-select">
                <option selected disabled>Status</option>
                <option  v-for="(item,index) in status" :key="index" :value="item">{{item}}</option>

              </select>
             </div>
             <div class="col-xl-4">
              <select class="form-select">
                <option selected disabled>Auditor</option>
              </select>
             </div>
             <div class="col-xl-4">
              <select class="form-select">
                <option selected disabled>Severity</option>
                <option  v-for="(item,index) in severities" :key="index" :value="item">{{item}}</option>

              </select>
             </div>
            </div>
        </div>
      </div>
      <div class="row mx-0">
        <div class="py-3 accordion">
          <IssueSection v-if="drapo"  v-for="issue in issues" :key="issue.id" :issue_p="issue" :status="status"/>
          <stats v-if="drapoStats"/>

      </div>
      </div>
       
    </main>
</template>

<script setup>
  import IssueSection from "@/components/projet/IssueSection.vue";
  import stats from "@/components/projet/stats.vue";

  import newIssue from "@/components/projet/newIssue.vue";
  import { useAuditStore } from '@/stores/audit'

  import { ref, onMounted, reactive, computed, watch, inject } from 'vue';
  const issueStore = useAuditStore();
  const severities = ref(['Critical','High','Medium','Low','Info','Und']);
  const status = ref(['Not Fixed','Fixed','Acknowledged','Mitigated','Partially Fixed']);
  
  const drapo = ref(true);
 const drapoStats = ref(false);
 const getIssues = async () =>{

  
 }
  const issues = ref([
              {
                id:1,
                code:'SHB-1',
                title:'Issue Title 1',
                likelihood:1,
                impact:2,
                severity:'Critical',
                status:'Not Fixed',
                user:{
                  full_name:'Inas Hasnaoui'
                },
                state:'Draft',
                description:'',
                exploit_scenario:'',
                recommendation:'',
                updates:''

              },
              {
                id:2,
                code:'SHB-2',
                title:'Issue Title 2',
                likelihood:1,
                impact:2,
                severity:'Medium',
                status:'Fixed',
                user:{
                  full_name:'Inas Hasnaoui'
                },
                state:'Approved',
                description:'',
                exploit_scenario:'',
                recommendation:'',
                updates:''

              }
            ]);
    const IssueScope = reactive({
      scope : "All Issues"
    })
    watch(
   [IssueScope],
  ([newIssueScope]) => {
      console.log(newIssueScope.scope)
      if(newIssueScope.scope == "Stats"){
        drapo.value = false;
        drapoStats.value = true;

      }else{
        drapo.value = true;
        drapoStats.value = false;
      }
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