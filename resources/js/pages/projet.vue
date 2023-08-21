<script setup>
import Footer from '../components/layouts/footer.vue';
import Paginate from "vuejs-paginate-next";
import PaginationComp from "@/pages/Pagination.vue";
import moment from 'moment';

import {  onMounted, reactive ,ref ,watch,inject} from 'vue';
const tags = reactive({ data: [] })
const status = reactive({ data: [] })
const language = reactive({ data: [] });
const projects = reactive({ data: null });
const toast = inject('toast');

const current_page = ref(1);

const projetModel = reactive({
'name': '',
'tag': '',
'status': '',
'language': '',
'scope' : 'me/audits'
})
const formattedDate   = (date) => {
      return moment(date).format('YYYY-MM-DD hh:mm:ss');
    }

const lastPage = ref(2);
const getTags = async () => {
    const response = await axios.get("/tags");
       tags.data = response.data;
}

const getStatus = async () => {
    const response = await axios.get("/statuses")
    status.data = response.data;
}
const getLanguage = async () => {
    const response = await axios.get("/skills")
    language.data = response.data;
}
const duplicate =  () => {
    toast.success('Project is duplicate');

}

const getProjet =  async (page = 1) => {

   axios.get(`/${projetModel.scope}?page=${page}`, {
                    params: {
                        name: projetModel.name,
                        language : projetModel.language,
                        tag : projetModel.tag,
                        status : projetModel.status,
                    }
                })
                    .then(response => {
                        projects.data = response.data.data;
                        lastPage.value= response.data.meta.last_page;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

    //projet.data = response.data.data;
    //lastPage.value= response.data.meta.last_page;
    //console.log(response)

}

/* function filteredList() {
   let tab =  projet.data.filter((pr) =>
     pr.name.toLowerCase().includes(projetModel.value.name)
  );

    projet.data = tab;




} */
onMounted(async () => {
    await getTags();
    await getStatus();
    await getLanguage();
     getProjet();

});

const changePage = async (page) =>{
    current_page.value = page;
    await getProjet(page);
}

/* watch(
    [() => projetModel.value,
    ()=> current_page.value],

    ([n]) => {
       /*  current_page = 1;
        getProjet(); */
   /*     console.log('test')
    }
) */
watch(
  [projetModel],
  ([newProjetModel, newCurrentPage]) => {
    current_page.value = 1,
     getProjet();
     console.log(projects.data)
  }
);
</script>


<template>
  <main>
    <div class="container">
        <div class="row mx-0 my-5">
            <h1>Audits</h1>
        </div>
        <div class="row mx-0 mb-5">
            <div class="col-xl-4 mb-2">
                <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" :class="{'active':projetModel.scope=='me/audits'}" @click="projetModel.scope='me/audits'"> My Audits </button>
                <button type="button" class="btn btn-light" :class="{'active':projetModel.scope=='lead/audits'}"  @click="projetModel.scope='lead/audits'"> My Lead Audits </button>
                <button type="button" class="btn btn-light" :class="{'active':projetModel.scope=='audits'}"  @click="projetModel.scope='audits'"> All Audits </button>
            </div>
            </div>
            <div class="col-xl-4 mb-2">
                <div class="searchBox ">
                    <input class="searchInput" type="search"  placeholder="Search : Project Name" v-model="projetModel.name">
                    <button class="searchButton" @click="filteredList">
                        <i class="fa fa-search">
                        </i>
                    </button>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="row mx-0">
                    <div class=" col-xl-4 mb-2">
                    <select class="form-select" aria-label="Default select example" v-model="projetModel.status">
                        <option value="" selected>Status</option>
                        <option v-for="(c, i) in status.data" :value="c.id" :key="i">{{ c.name ?? ''}}</option>
                </select>
                </div>
                <div class=" col-xl-4 mb-2">
                <select class="form-select" aria-label="Default select example" v-model="projetModel.tag">
                        <option value="" selected >Tags</option>
                        <option v-for="(c, i) in tags.data" :value="c.id" :key="i">{{ c.name ?? '' }}</option>
                </select>
                </div>
                <div class=" col-xl-4 mb-2">
                <select class="form-select" aria-label="Default select example" v-model="projetModel.language">
                        <option  value="" selected>Language</option>
                        <option v-for="(c, i) in language.data" :value="c.id" :key="i">{{ c.name ?? '' }}</option>
                </select>
                </div>
                </div>

        </div>
        </div>

        <div v-if="projects.data != null ">
            <div class="row mx-0" v-if="projects.data.length > 0 ">


                <div class="col-xl-4 col-md-4 mb-5" v-for="(c, i) in projects.data" v-bind:key="i">
                    <div class="card ">
                        <div class="row m-0">
                            <div class="col-xl-10 col-md-10">
                                <div class="status-label mb-2">{{ c.status ? c.status.name : '' }}</div>
                                <div class="card-header ">
                                <h4><router-link :to="`/audit/${c.id}`" class="card-title  text-dark"> {{ c.name ?? '' }} </router-link></h4>
                                    <span class="badge bg-card">{{ c.client ?? '' }}</span>
                                    <!-- <span class="badge bg-card float-end">23</span> -->

                                </div>
                                <div class="card-body row">
                                    <div class="row mx-0 justify-content-center">
                                        <div class="col-xl-5 col-md-6">
                                        <span class="issue" title="Issue"> <i class="fa fa-bug"></i> 20</span>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <span class="issue" title="Best Practices"><i class="fas fa-shield-alt"></i>20</span>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <span class="issue" title="Resolved"> <i class="far fa-check-circle"></i>20</span>
                                    </div>
                                    </div>
                                    <div class="row mx-0 px-0 text-dark text-center">
                                    <span class="col-xl-6" title="Start Date"><i class="far fa-hourglass"></i>{{ c.start_date }}</span>
                                    <span class="col-xl-6 " title="End Date"><i class="fas fa-hourglass"></i>{{ c.finish_date }}</span>
                                    </div>

                                    <div class="text-center my-2">
                                        <span class="badge rounded-circle bg-cri">7</span>
                                        <span class="badge rounded-circle bg-high">3</span>
                                        <span class="badge rounded-circle bg-med text-dark">5</span>
                                        <span class="badge rounded-circle bg-low">4</span>
                                        <span class="badge rounded-circle bg-info">4</span>
                                        <span class="badge rounded-circle bg-und">8</span>
                                    </div>
                                    <div class="row mx-0 px-0 text-end">
                                    <span class="text-l">{{ formattedDate(c.updated_at) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2  col-md-2 side d-lg-grid d-xl-grid d-md-grid py-3">
                                <i class="far fa-edit" title="Edit"></i>
                                <i class="fas fa-file-download" title="Download"></i>
                                <i class="fas fa-copy" title="Duplicate" @click="duplicate"></i>
                                <i class="fas fa-eye" title="Preview"></i>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="text-end my-5 " >

                    <PaginationComp :current_page=current_page :last_page_url=lastPage
                                v-on:change-page="changePage"/>
                </div>
            </div>
            <div class="alert alert-dark" v-else>

                No Data Found

            </div>
         </div>
    </div>
  </main>
</template>


<style scoped>
.side{
    background-color: var(--secondColor);
    text-align: center;
    align-items: center;
    border-radius: 0px 12px 12px 0px;

}
.card{
    border-radius: 12px;
    border-color: var(--secondColor);
    box-shadow:0 10px 18px rgba(0, 0, 0, 0.25), 0 6px 6px rgba(0, 0, 0, 0.22);

}
.btn.active{
    background-color: #75B0FE;
}
i {
    padding: 14px 8px;
}
.issue{
     font-size: 14px;
     color: var(--blackColor);
}
.bg-card,.active{
    background-color: var(--navActive);
}
.rounded-circle{
    padding: 8px 10px;
    margin: 4px 6px;
}
.text-l{
    font-size: 12px;
    color: var(--grayColor);
}
.btn-light{
    border-color: var(--blackBorder);
}
.searchBox {
background: var(--whiteColor);
color: var(--searchColor);
height: 40px;
border-radius: 40px;


}

.searchButton {
float: right;
width: 40px;
height: 40px;
background: var(--whiteColor);
color: var(--searchColor);
border-radius: 50%;
display: flex;
justify-content: center;
align-items: center;
transition: 0.4s;
}

.searchInput {
border: none;
width: 90%;
padding: 0 16px;
background: none;
outline: none;
float: left;
font-size: 16px;
transition: 0.4s;
line-height: 40px;

}
@media screen and (max-width: 620px) {
.searchBox:hover > .searchInput {
    width: 180px;
    padding: 0 14px;
}
}
.status-label {
    border-radius: 0 12px 12px 0;
    left: -12px;
    position: relative;
    top: 10px;
    display: inline-block;
    font-size: 12px;
    padding: 5px 14px;
    text-transform: uppercase;
    background:var(--statusColor);
}
.card-header{
	background-color: inherit !important;;
}
.side i{
    cursor: pointer;
}
a{
    text-decoration: none!important;
}
a:hover{
    color: var(--btnBg)!important;
}

ul:hover{
	cursor:pointer;
}

</style>
