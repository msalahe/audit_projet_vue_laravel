<script setup>
import {useIssueStore} from '@/stores/issue'
import {useProjectStore} from '@/stores/projectStore'

import { onMounted,ref} from "vue";
import { useRouter } from 'vue-router';
import {useAuthStore} from '@/stores/authuser'
import {useAuditStore} from '@/stores/audit'

import vulnurabilites from '@/components/modals/issues/index.vue'
import project from '@/components/modals/project/create.vue'
import settings from '@/components/modals/settings/settings.vue'

const router = useRouter()
const issueStore = useIssueStore()
const auditStore = useAuditStore()

const userStore = useAuthStore()
const projectStore = useProjectStore();

const isAdmin  = ref("");
const logout =  () =>{
     userStore.logout()
}

onMounted(async () => {

  console.log(userStore.data.role)

});



</script>

<template >

<nav class="navbar navbar-expand-lg px-4 py-2">
  <div class="container-fluid">
    <div class="navbar-brand">
        <img class="navbar-brand" src="/assets/image/logo-w.png"  width="150"/>

    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <router-link to="/"  class="nav-link" > Audits </router-link>
        <a  class="nav-link"  @click="auditStore.toggleIssueModal(false)">Settings</a>
        <span class="nav-link" @click="issueStore.toggleIssueModal(false)" >Vulns</span>
        <router-link to="/users"  class="nav-link" v-if=" userStore.data.role == 'Admin'" > Auditors/BDs </router-link>
        <span class="nav-link btn"><i class="fas fa-plus-circle mx-2" @click="projectStore.toggleProjectModal(false)"></i></span>
        <span class="nav-link btn"  @click="logout"><i class="fas fa-sign-in-alt mx-2"></i></span>
      </div>
    </div>
  </div>
  <vulnurabilites  v-if="issueStore.data.open" />
  <project  v-if="projectStore.data.open" />
  <settings  v-if="auditStore.data.open" />

  </nav>
</template>
<style scoped>

.navbar-light .navbar-brand ,.nav-link{
        color: var(--navLink)!important;
        font-family: "Heebo";
       font-weight: 600;
       line-height: 1.5em;
        text-align: center;
        font-size: 18px;
    }
    .router-link-exact-active.nav-link{
        color:  var(--navActive)!important;
        border-bottom: 2px solid  var(--navActive);
    }

  .nav-link:hover {
        color: var(--navActive)!important;
    }

   .navbar,.nav{
        background: var(--navBg)!important;

    }
.nav-link{
	cursor: pointer;
}
</style>
