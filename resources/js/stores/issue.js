import { defineStore } from 'pinia';
import { reactive, readonly, inject } from 'vue';

export const useIssueStore = defineStore('issue', () => {
    const data = reactive({
        open: false, form: false, show: null, issues: [],
        model: {
            'title': '',
            'description': '',
            'attack_scenario': '',
            'recommendation': '',
            'likelihood': '',
            'impact': '',
            'category': '',
        }
    })
    const toast = inject('toast');

    function toggleIssueModal(r = true) {
        data.open = !data.open
        if (r) {
            data.show = null
            data.form = false
        }
    }

    function toggleIssueForm() {
        data.form = !data.form
    }

    function toggleIssueShow(issue = null) {
        data.show = issue
        console.log(1)
    }

    function getIssueById(id) {
        const issue = data.issues.find(issue => issue.id === id);
        return data.issues.find(issue => issue.id === id) ? data.issues.indexOf(issue) : -1;
    }

    async function getIssues() {
        const response = await axios.get("/issues")
        data.issues = response.data;

    }

    function saveIssue(m) {
        data.show != null ? updateIssue(m) : storeIssue(m)
    }

    async function storeIssue(m) {
        const issue = await axios.post("/issues", m).then(issue => {
            toast.success('Issue has been created')
            console.log(issue.data.issue)
            data.issues.push(issue.data.issue)
            toggleIssueModal()
        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }

    async function updateIssue(m) {
        const issue = await axios.post(`/issues/${data.show.id}`, m).then(issue => {
            toast.success('Issue has been updated')
            data.show = issue.data.issue
            data.issues.splice(data.issues[getIssueById(m.id)], 1, issue.data.issue)
            toggleIssueModal()
        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }

    async function deleteIssue() {
        const response = await axios.delete(`/issues/${data.show.id}`)
            .then(issue => {
                toast.success('Issue has been delete')
                data.issues.splice(data.issues[getIssueById(data.show.id)], 1)
                toggleIssueModal()
            }).catch(function (error) {
                toast.error(error.response.data.message)
            })
    }

    return {
        data: readonly(data),
        toggleIssueModal,
        toggleIssueForm,
        toggleIssueShow,
        getIssueById,
        getIssues,
        saveIssue,
        deleteIssue
    }
});
