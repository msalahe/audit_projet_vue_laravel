<template>
    <div class="accordion-item">

        <div class="accordion-collapse">

            <div class="accordion-body">
                <div class=" mx-0 ">
                    <div class="col-xl-5  ">
                        <AutoComplete v-model="issue" :suggestions="filteredIssues" @complete="searchIssues($event)" />
                    </div>
                </div>
                <div class="row mx-0">

                    <div class="col-xl-6 mb-2">
                        <label class="col-form-label">Title</label>
                        <input type="text" class="form-control" v-model="IssuesModel.title">
                    </div>
                    <div class="col-xl-3 mb-2">
                        <label class="col-form-label">Likelihood</label>
                        <select class="form-select" v-model="IssuesModel.likelihood">
                            <option :value="1">HIGH</option>
                            <option :value="2">MEDIUM</option>
                            <option :value="3">LOW</option>
                        </select>
                    </div>
                    <div class="col-xl-3 mb-2">
                        <label class="col-form-label">Impact</label>
                        <select class="form-select" v-model="IssuesModel.impact">
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                            <option value="0">Info</option>
                            <option value="-1">Undetermined</option>
                        </select>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-6 mb-2">
                        <label class="col-form-label">Status</label>
                        <select class="form-select" v-model="IssuesModel.status">
                            <option selected disabled>Status</option>
                        </select>
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label class="col-form-label">Severity</label>
                        <input type="text" class="form-control" v-model="IssuesModel.severity">
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 mb-2">
                        <label class="col-form-label">Description</label>
                        <textarea rows="4" class="form-control" v-model="IssuesModel.description"></textarea>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 mb-2">
                        <label class="col-form-label">Exploit Scenario</label>
                        <textarea rows="4" class="form-control" v-model="IssuesModel.exploit_scenario"></textarea>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-8">
                        <label class="col-form-label">Affected Files</label>
                        <input type="text" class="form-control" v-model="IssuesModel.affectedFiles">

                    </div>
                    <div class="col-xl-2">
                        <label class="col-form-label">S.Line</label>
                        <input type="number" min="1" class="form-control">
                    </div>
                    <div class="col-xl-2 text-end add">
                        <i class="fas fa-plus-circle fa-2x"></i>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 mb-2">
                        <label class="col-form-label">Recommendation</label>
                        <textarea rows="4" class="form-control " v-model="IssuesModel.recommendation"></textarea>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 mb-2">
                        <label class="col-form-label">Updates</label>
                        <textarea rows="4" class="form-control" v-model="IssuesModel.updates"></textarea>
                    </div>
                </div>

                <div class="row mx-0 my-3">
                    <div class="col-xl-3 mb-2">
                        <select class="form-select form-custom text-white" v-model="IssuesModel.status"
                            v-bind:style="{ backgroundColor: stateColor }">
                            <option selected disabled>State</option>
                        </select>
                    </div>
                    <div class="col-xl-5 mb-2 ms-auto text-end">
                        <button class="btn btn-success mx-1">Save</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref, inject, watchEffect } from 'vue';
import AutoComplete from 'primevue/autocomplete';


let issues = ref();

let issue = ref();

const IssuesModel = reactive({
    title: '',
    likelihood: '',
    impact: '',
    status: '',
    severity: '',
    description: '',
    exploit_scenario: '',
    recommendation: '',
    updates: '',
    affectedFiles: [{
        file_name: '',
        start_line: '',
        code: ''
    }],
})

const getAllIssues = async () => {
    const response = await axios.get(`/issues`);

    issues.value = response.data;
    console.log(issues.value);
}

onMounted(async () => {
    await getAllIssues();

});

const filteredIssues = ref([]);
const ObjectIssues = ref([]);

const searchIssues = (value) => {


    if (filteredIssues.value[0]?.title == undefined) {
    } else {
        console.log(filteredIssues.value[0])
        issue.value = filteredIssues.value[0].title;
        IssuesModel.title = filteredIssues.value[0].title;
        IssuesModel.attack_scenario = filteredIssues.value[0].attack_scenario;
        IssuesModel.description = filteredIssues.value[0].description;
        IssuesModel.impact = filteredIssues.value[0].impact;
        IssuesModel.likelihood = filteredIssues.value[0].likelihood;
        IssuesModel.recommendation = filteredIssues.value[0].likelihood;
    }

};

watchEffect(() => {
    filteredIssues.value = issues.value
        ? issues.value
            .filter((issu) =>
                issu.title.toLowerCase().startsWith(issue.value)

            )

        : [];
});


</script>

<style scoped>
.form-custom {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}

.add {
    align-items: flex-end;
    display: flex;
    justify-content: center;
    margin-bottom: 12px;
    cursor: pointer;
}

.accordion-item {
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.accordion-collapse {
    background-color: var(--themeBg);

}

.accordion-button {
    background-color: var(--themeBg);
    color: var(--whiteColor);
}

.accordion-item {
    color: var(--whitecolor);
}

.accordion-button:not(.collapsed) {
    background-color: var(--accordianActive);
}

.accordion-button.collapsed::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.form-control,
.form-select {
    color: var(--whiteColor);
    border: none;
    padding: 12px;
    background-color: var(--navBg);
}

.form-select {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}

.col-form-label {
    float: left;
}

.accordion-body {
    padding: 1%;

}

.importIssue {
    float: right;
    margin: 10%;
}
</style>