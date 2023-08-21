import { url } from '@vuelidate/validators';
import { forEach } from 'lodash';
import { defineStore } from 'pinia';
import { reactive, readonly, inject } from 'vue';


export const useAuditStore = defineStore('audit', () => {
    const data = reactive({
        open: false,
        save: false,
        projet:
        {
            summary: {


                detail: {
                    id: "", name: "", client_name: "", start_date: "", finish_date: "", jira_id: "",
                    description: "", tags: [], slack_channel: "", status: "", type: "", languages: [], 
                    languagesDefault: [], blockchains: [], blockchainsDefault : [],tagsDefault : []
                },
                scope: [{
                    name: "Audit",
                    repo: [{ repos: 'audit', commit: 'audit' }],
                    files: []
                }, {
                    name: "Re-Audit",
                    repo: [{ repos: 'Re-Audit', commit: 'Re-Audit' }],
                    files: []
                }],
                summary: { Disclaimer: "", summary: "" },
                key_fiding: { description: "" },
                quality_assessment: [],
                nameScope: "Audit",

                conclusion: "",
            },
            team: [],
            bps: [],
            tests: {
                introduction: '',
                conclusion: '',
                testScenarios: []
            }
        },
        showIssue: false,
        showBp: false,
        currentTab: 'Summary',
        defaultValue: [],
        stats: { high: 0, undetermined: 0, info: 0, low: 0, med: 0, cri: 0 }

    })

    function toggleIssueModal(r = true) {
        data.open = !data.open
    }
    function setSaveEtat(etat) {
        console.log(etat)
        data.save = etat;
    }
    function showIssue() {
        data.showIssue = !data.showIssue
    }
    function showBps() {
        data.showBp = !data.showBp
    }
    async function getSummuaryProjet(idProjet) {
        const response = await axios.get(`/audits/${idProjet}`)
        const res = response.data.project
        const stats = response.data.stats;


        data.projet.summary.detail.id = res.id || '';
        data.projet.summary.detail.name = res.name || '';
        data.projet.summary.detail.client_name = res.client || '';
        data.projet.summary.detail.start_date = res.start_date || '';
        data.projet.summary.detail.finish_date = res.finish_date || '';
        data.projet.summary.detail.jira_id = res.jira_id || '';
        data.projet.summary.detail.slack_channel = res.slack_channel || '';
        data.projet.summary.detail.description = res.description || '';
        data.projet.summary.detail.status = res.status_id || '';
        data.projet.summary.detail.type = res.type || '';
        //disclaimer summary
        data.projet.summary.summary.Disclaimer = res.disclaimer || '';
        data.projet.summary.key_fiding.description = res.findings || '';
        data.projet.summary.summary.summary = res.summary || '';
        data.projet.summary.conclusion = res.conclusion || '';


        data.stats.high = stats.original.issues.by_severity.High;
        data.stats.undetermined = stats.original.issues.by_severity.Undetermined;

        // qas 

        const qas = await axios.get(`/audits/${idProjet}/qas`)
        data.projet.summary.quality_assessment = qas.data;

        console.log(data.projet.summary.quality_assessment);

        if (data.projet.summary.quality_assessment.length == 0) {
            data.projet.summary.quality_assessment.push({ name: '', link: '', quality: 1 })
        }



        let languages = [];
        languages = res.languages;
        let blockchains = [];
        blockchains = res.blockchains;
        
        let tags = [];
        tags = res.tags;
        let tablanguages = [];
        languages.forEach(element => {
            tablanguages.push(element.id)
            data.projet.summary.detail.languages.push({ id: element.id });
        });

        data.projet.summary.detail.languagesDefault = tablanguages;
        console.log(data.projet.summary.detail.languages)

        let tabblockchains = [];
        for (const b of blockchains) {
            tabblockchains.push(b.id);
            data.projet.summary.detail.blockchains.push({ id: b.id });

        }
        data.projet.summary.detail.blockchainsDefault = tabblockchains;
        let tabtags = [];
        for (const t of tags) {
            tabtags.push(t.id);
            data.projet.summary.detail.tags.push({ id: t.id });

        }
        data.projet.summary.detail.tagsDefault = tabtags;


        // bps
        data.projet.bps = res.best_practices


    }
    async function setDefault() {
        const response = await axios.get(`/audits/${idProjet}`)
        data.defaultValue = response.data;

    }
    function setFile(files) {
        for (let i = 0; i < data.projet.summary.scope.length; i++) {
            if (data.projet.summary.scope[i].name === data.projet.summary.nameScope) {
                data.projet.summary.scope[i].files = files;

            }
        }
        console.log(data.projet.summary.scope);

    }
    function getFiles() {
        for (let i = 0; i < data.projet.summary.scope.length; i++) {
            if (data.projet.summary.scope[i].name === data.projet.summary.nameScope) {
                return data.projet.summary.scope[i].files;
            }
        }
    }
    function setCurrentTab(tab) {
        data.currentTab = tab;

    }

    function pushBp(bp) {
        data.projet.bps.push(bp)
        console.log(bp)
    }
    function getRepoByName(name) {
        for (let i = 0; i < data.projet.summary.scope.length; i++) {
            if (data.projet.summary.scope[i].name === name) {
                return data.projet.summary.scope[i];
            }
        }

        return null; // repository not found
    }

    function addRepos() {
        for (let i = 0; i < data.projet.summary.scope.length; i++) {
            if (data.projet.summary.scope[i].name === data.projet.summary.nameScope) {
                console.log(data.projet.summary.scope[i]);
                data.projet.summary.scope[i].repo.push({ repos: '', commit: '' });
            }
        }
    }
    function saveCurrentTab() {
        switch (data.currentTab) {
            case 'Summary':
                saveSummury();
                break;
            case 'Issues':
                //saveIssue(dataModel);
                break;
            case 'Team':
                saveTeam();
                break;
            case 'Best Practices':
                //saveBp(dataModel);
                break;
            case 'Tests':
                //saveTest(dataModel);
                break;
        }
    }
    function getDefault(name) {
        data.projet.summary.conclusion = name;
    }

    const saveBp = async () => {
        const issue = await axios.post(`/audits/${data.projet.detail.id}/bps`, data.bps).then(bp => {
            toast.success('Best practice has been created')
            auditStore.showBps()
            auditStore.pushBp(bp.data.projectBp)
            bpModel.title = ''
            bpModel.description = ''
            bpModel.affectedFiles = [{
                file_name: '',
                start_line: '',
                code: ''
            }]
        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }
    const saveTest = async (bpModel) => {
        const issue = await axios.post(`/audits/${data.projet.detail.id}/bps`, data.projet.team).then(bp => {
            toast.success('Best practice has been created')
            auditStore.showBps()
            auditStore.pushBp(bp.data.projectBp)
            bpModel.title = ''
            bpModel.description = ''
            bpModel.affectedFiles = [{
                file_name: '',
                start_line: '',
                code: ''
            }]
        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }

    function addEtatStore(etat) {
        data.projet.summary.scope.push({ name: etat, repo: [{ repos: '', commit: '' }] });
    }
    const saveTeam = async () => {
        const issue = await axios.post(`/audits/${data.projet.summary.detail.id}/users`, { users: data.projet.team }).then(bp => {

        }).catch(function (error) {
            console.log(error)
        })
    }
    const saveIssue = async (bpModel) => {
        const issue = await axios.post(`/audits/${data.projet.detail.id}/bps`, bpModel).then(bp => {
            toast.success('Best practice has been created')
            auditStore.showBps()
            auditStore.pushBp(bp.data.projectBp)
            bpModel.title = ''
            bpModel.description = ''
            bpModel.affectedFiles = [{
                file_name: '',
                start_line: '',
                code: ''
            }]
        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }
    const saveSummury = async () => {
        alert("alert")
        console.log(data.projet.summary.detail.tags);
        const summury = await axios.post(`/audits/${data.projet.summary.detail.id}`, data.projet.summary).then(bp => {

        }).catch(function (error) {
            console.log(error)
            toast.error(error.response.data.message)
        })
    }
    const deleteRepos = (ind) => {
        for (let i = 0; i < data.projet.summary.scope.length; i++) {
            if (data.projet.summary.scope[i].name === data.projet.summary.nameScope) {
                data.projet.summary.scope[i].repo.splice(ind, 1);
            }
        }
    }

    return {
        data,
        toggleIssueModal,
        setSaveEtat,
        showIssue,
        showBps,
        getSummuaryProjet,
        pushBp,
        setCurrentTab,
        saveCurrentTab,
        getRepoByName,
        addRepos,
        addEtatStore,
        deleteRepos,
        getDefault,
        setFile,
        getFiles
    }
});

