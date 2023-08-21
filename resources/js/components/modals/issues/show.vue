<script setup>
import { reactive } from 'vue'
import modal from '@/components/modal.vue'
import { useIssueStore } from '@/stores/issue'
import edit from './edit.vue'

const issueStore = useIssueStore()
const issue = issueStore.data.show
const confirmDelete = reactive({ value: false })

const thClassValue =   (id) => {
    var value = 'badge badge-success text-' + id

    return value;
  }
</script>

<template>
        <div class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-header  text-center">
                    <button type="button" @click="$emit('close')" class="btn-close btn-close-white"></button>
                </div>
                <div class="modal-content">
                    <div class="modal-header  text-center border-bottom-0">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h3><span :class="thClassValue(issue.severity)">{{ issue.severity }}</span> <span class="fnt">{{
                                    issue.title }}</span></h3>
                            </div>
                        </div>
                        <div class="">


                        </div>
                        <div class="mt-5" role="button" @click="issueStore.toggleIssueShow()">
                            <font-awesome-icon :icon="['fas', 'circle-arrow-left']" />
                            Return
                        </div>
                    </div>
                    <div class="modal-body p-3">
                        <div class="d-flex justify-content-end mb-5 mr-5">
                            <font-awesome-icon icon="pen-to-square" class="mx-2" role="button"
                                @click="issueStore.toggleIssueForm()" />
                            <font-awesome-icon :icon="['far', 'trash-can']" class="mx-1" role="button"
                                @click="confirmDelete.value = true" v-if="!confirmDelete.value" />
                            <button class="btn btn-sm btn-danger mx-2" v-if="confirmDelete.value"
                                @click="issueStore.deleteIssue()">
                                <font-awesome-icon :icon="['fas', 'check']" class="mx-1" role="button" /> Confirm
                            </button>
                            <button class="btn btn-sm btn-warning" v-if="confirmDelete.value"
                                @click="confirmDelete.value = !confirmDelete.value">
                                <font-awesome-icon :icon="['fas', 'ban']" class="mx-1" role="button" /> Cancel
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="fnt">
                                    <h6> Description :</h6>
                                    <div class="fnt">
                                        {{ issue.description }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="d-flex">
                                    <h6 class="flex-fill fnt"> Likelihood : {{ issue.likelihood }} </h6>
                                    <h6 class="flex-fill fnt"> Impact : {{ issue.impact }} </h6>
                                </div>
                                <div class="mt-4">
                                    <h6 class="fnt">Category : {{ issue.category.name }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 col-12 fnt">
                                <h6> Exploit scenario :</h6>
                                <div class="fnt">
                                    {{ issue.attack_scenario }}
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <h6 class="fnt"> Recommendation :</h6>
                                <div class="fnt">
                                    {{ issue.recommendation }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    <edit v-if="issueStore.data.form"></edit>

</template>

<style scoped src="@/../css/popup.css"></style>
<style scoped src="@/../css/colors.css"></style>

<style scoped>
.link {
    cursor: pointer;
}

.link:hover {
    color: var(--navActive);
    text-decoration: underline;
}

.form-control,
.form-select {
    color: var(--whiteColor);
    padding: 12px;
    border: none;
    border-radius: 12px;
    background-color: var(--themeBg);
}
</style>

