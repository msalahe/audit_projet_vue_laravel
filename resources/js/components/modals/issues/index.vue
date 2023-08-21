<template>
    <div class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header  text-center border-bottom-0">
                    <h2 data-v-1c34c0ea="" class="modal-title mx-auto">Common Known Vulnerabilities</h2>
                    <button type="button" @click="issueStore.toggleIssueModal()" class="btn-close btn-close-white"></button>

                </div>
                <div class="modal-body p-3">
                    <div class="row mx-0 mb-3  text-end">
                        <span class="link ms-auto" @click="issueStore.toggleIssueForm()">Add New Vuln <i
                                class="fas fa-chevron-right ms-2"></i></span>
                    </div>
                    <div class="vulns my-2" v-if="issueStore.data.show == null">
                        <div class="row mx-0">
                            <div class="col-xl-6 " v-for="(item, index) in categorizedIssues" :key="index">
                                <h6 class="mb-3"><i class="fas fa-folder me-2"></i>{{ item[0].category.name }} </h6>
                                <ul>
                                    <li class="mb-2 link" v-for="vuln in item" :key="vuln.id"><i
                                            class="far fa-file-alt me-2"></i>
                                        <span @click="editIssue(vuln)">
                                            {{ vuln.title }}
                                        </span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
                <VulnPopup v-if="issueStore.data.form && issueStore.data.show == null"  />
                <show v-else-if="issueStore.data.show != null"></show>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, onMounted, computed, ref } from 'vue'
import VulnPopup from "@/components/modals/issues/form.vue";
import show from './show.vue'

import { useIssueStore } from '@/stores/issue'

const issueStore = useIssueStore()

//const issues = reactive({ data: [] })

/* const getIssues = async () => {
    const response = await axios.get("/issues")
    issues.data = response.data;
} */


const editIssue = (issue) => {
    issueStore.toggleIssueShow(issue)
}
const categorizedIssues = computed(() => {
    return issueStore.data.issues.reduce((acc, issue) => {
        let  categoryName;
        if(issue.category === null){
            categoryName = null
        }else{
            categoryName = issue.category.name
        }
        if (!acc[categoryName]) {
            acc[categoryName] = []
        }
        acc[categoryName].push(issue)
        return acc
    }, {}) || []
})

onMounted(async () => {
    await issueStore.getIssues()

});
</script>
<style scoped src="@/../css/popup.css"></style>

<style scoped src="@/../css/table.css"></style>
<style scoped>
ul {
    list-style-type: none;
}

.link {
    cursor: pointer;
}

.link:hover {
    color: var(--navActive);
    text-decoration: underline;
}

.vulns::-webkit-scrollbar {
    width: 8px;

}

.vulns::-webkit-scrollbar-track {
    background: none;
}

.vulns::-webkit-scrollbar-thumb {
    background-color: var(--thumbBG);
    border-radius: 6px;
}

.vulns {
    scrollbar-width: thin;
    scrollbar-color: var(--thumbBG) var(--scrollbarBG);
    max-height: 500px;
    overflow-y: scroll;

}</style>
