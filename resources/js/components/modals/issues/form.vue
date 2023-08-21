<template>
    <div class="modal modal-lg fade show" tabindex="-1" aria-modal="true" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header  text-center">
                    <h4 class="modal-title">Add Vulnerability</h4>
                    <button type="button" @click="issueStore.toggleIssueModal()" class="btn-close btn-close-white"></button>

                </div>
                <div class="modal-body p-3">
                    <div class="row mx-0 mb-3  text-end">
                        <span class="link ms-auto" @click="issueStore.toggleIssueForm()"><i
                                class="fas fa-chevron-left me-2"></i> Back to
                            the List </span>
                    </div>
                    <div class="row mx-0">

                        <div class="col-xl-6 mb-2">
                            <label class="col-form-label">Title</label>
                            <input type="text" class="form-control"
                                :class="{ 'is-invalid': errors.value.title && errors.value.title.$invalid }"
                                v-model="issueModel.title">
                            <div class="invalid-feedback" v-if="errors.value.title && errors.value.title.$invalid">
                                {{ errors.value.title.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>
                        <div class="col-xl-3 mb-2">
                            <label class="col-form-label">Likelihood</label>
                            <select class="form-select" v-model="issueModel.likelihood"
                                :class="{ 'is-invalid': errors.value.likelihood && errors.value.likelihood.$invalid }">
                                <option v-for="(n, i) in [1, 2, 3]" :value="n" :key="i">
                                    {{ likelihood[i] }}
                                </option>
                            </select>
                            <div class="invalid-feedback"
                                v-if="errors.value.likelihood && errors.value.likelihood.$invalid">
                                {{ errors.value.likelihood.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>
                        <div class="col-xl-3 mb-2">
                            <label class="col-form-label">Impact</label>
                            <select class="form-select" v-model="issueModel.impact"
                                :class="{ 'is-invalid': errors.value.impact && errors.value.impact.$invalid }">
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                                <option value="0">Info</option>
                                <option value="-1">Undetermined</option>
                            </select>
                            <div class="invalid-feedback" v-if="errors.value.impact && errors.value.impact.$invalid">
                                {{ errors.value.impact.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-xl-6 mb-2">
                            <label class="col-form-label">Description</label>
                            <textarea rows="4" class="form-control" v-model="issueModel.description"
                                :class="{ 'is-invalid': errors.value.description && errors.value.description.$invalid }"></textarea>
                            <div class="invalid-feedback"
                                v-if="errors.value.description && errors.value.description.$invalid">
                                {{ errors.value.description.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="col-form-label">Category</label>
                            <select class="form-select mb-2" v-model="issueModel.category"
                                :class="{ 'is-invalid': errors.value.category && errors.value.category.$invalid }"
                                v-if="categories.data.length > 0">
                                <option selected disabled>Type</option>
                                <option v-for="(c, i) in categories.data" :value="c.id" :key="i">{{ c.name }}</option>
                            </select>
                            <input class="form-control ml-2" v-model="issueModel.new_category"
                                :class="{ 'is-invalid': errors.value.new_category && errors.value.new_category.$invalid }">
                            <div class="invalid-feedback" v-if="errors.value.category && errors.value.category.$invalid">
                                {{ errors.value.category.$silentErrors[0].$message ?? '' }}
                            </div>

                        </div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-xl-6 mb-2">
                            <label class="col-form-label">Exploit Scenario</label>
                            <textarea rows="4" class="form-control" v-model="issueModel.attack_scenario"
                                :class="{ 'is-invalid': errors.value.attack_scenario && errors.value.attack_scenario.$invalid }"></textarea>
                            <div class="invalid-feedback"
                                v-if="errors.value.attack_scenario && errors.value.attack_scenario.$invalid">
                                {{ errors.value.attack_scenario.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="col-form-label">Recommendation</label>
                            <textarea rows="4" class="form-control" v-model="issueModel.recommendation"
                                :class="{ 'is-invalid': errors.value.recommendation && errors.value.recommendation.$invalid }"></textarea>
                            <div class="invalid-feedback"
                                v-if="errors.value.recommendation && errors.value.recommendation.$invalid">
                                {{ errors.value.recommendation.$silentErrors[0].$message ?? '' }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success mx-1" @click="saveIssue">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive, watch, computed } from 'vue';
import { useIssueStore } from '@/stores/issue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'

const emit = defineEmits(['close'])
const issueStore = useIssueStore()

const issueModel = reactive({
    'title': '',
    'description': '',
    'attack_scenario': '',
    'recommendation': '',
    'likelihood': '',
    'impact': '',
    'category': '',
    'new_category': '',
})

const errors = reactive({ value: [] })

const rules = {
    title: { required },
    description: { required },
    attack_scenario: { required },
    recommendation: { required },
    likelihood: { required },
    impact: { required },
    category: requiredIf(issueModel.new_category == ''),
    new_category: requiredIf(issueModel.category == ''),

}

const likelihood = ref(['LOW', 'Medium', 'HIGH'])
const categories = reactive({ data: [] })

const getCategories = async () => {
    const response = await axios.get("/categories")
    categories.data = response.data;
}


const saveIssue = () => {
    const v$ = useVuelidate(rules, issueModel)

    errors.value = v$.value
    if (!v$.value.$invalid) {
        issueStore.saveIssue(issueModel)
    }


}

/* const isEdit = () => {
    return issueStore.data.show != null
}

const fillEdit = () => {
    if (isEdit()) {
        const m = issueStore.data.show
        issueModel.value = {
            'title': m.title,
            'description': m.description,
            'attack_scenario': m.attack_scenario,
            'recommendation': m.recommendation,
            'likelihood': m.likelihood,
            'impact': m.impact,
            'category': m.category.id,
            'new_category': '',
        }
    }
} */

watch(
    [() => issueModel.new_category, () => issueModel.category],
    ([newCategory, category]) => {
        if (newCategory && newCategory !== '') {
            issueModel.category = ''
        }
        if (category && category !== '') {
            issueModel.new_category = ''
        }
    }
)


onMounted(async () => {
    await getCategories()
    // fillEdit()
});
</script>

<style scoped src="@/../css/popup.css"></style>

<style scoped>


</style>

