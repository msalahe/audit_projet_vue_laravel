import { defineStore } from 'pinia';
import { reactive, readonly, inject } from 'vue';


export const useProjectStore = defineStore('project',() =>{
    const data = reactive({
        open: false,
        model: {
            'projet_name': '',
            'client_name': '',
            'start_date': '',
            'finish_date': '',
            'description': ''
        }

    })

    const toast = inject('toast');


    function toggleProjectModal(r = true) {
        data.open = !data.open
    }

    async function storeProject(p) {
       
    }
    return {
        data,
        toggleProjectModal,
        storeProject
    }
});
