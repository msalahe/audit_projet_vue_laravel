<script setup>
import { onMounted, ref, reactive,computed } from 'vue';
import { useRoute } from 'vue-router';
import rs from '@/config/rs.js'
import skillsChart from '@/components/charts/skills.vue'
import issuesChart from '@/components/charts/issues.vue'

const route = useRoute();
const userData = ref([])
const userProjects = ref([])
const roles = reactive({ data: [] })
const skills = reactive({ data: [] })

const getUser = async () => {
    const response = await axios.get(`/users/${route.params.id}`)
    userData.value = response.data.user;
    userProjects.value = response.data.projects;
}

const getRoles = async () => {
    const response = await axios.get("/roles")
    roles.data = response.data;
}

const getskills = async () => {
    const response = await axios.get("/skills")
    skills.data = response.data;
}

const getIcon = (n) => {
    const item = rs.find(i => i[0] === n);
    return item ? item[1] : null;
}

const userSkills = computed(() => {
    return  userData.value.skills ? userData.value.skills.map(skill => {
                return { id: skill.id, skill: skill.name,percentage:skill.pivot ? skill.pivot.level : null};
            }) : []
})


onMounted(async () => {
    await getUser()
    await getRoles()
    await getskills()
});

</script>

<template>

    <div class="row view01 divInfo" style="margin-top: 6%;">
        <!----><div class="col-lg-4 divInfo" >
            <div id="accordion" class="custom-accordion mb-4">

                <div class="card mb-0">
                    <div class="accordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button nav-pills" type="button" data-bs-toggle="collapse" data-bs-target="#details" aria-expanded="true" aria-controls="details">
                 Personal Info
                </button>
              </h2>
              <div id="details" class="accordion-collapse collapse show" >
                <div class="accordion-body">
                    <form action="#">
                                <div class="form-group">
                                    <label>Fulle Name</label>
                                    <input type="text" class="form-control" v-model="userData.full_name">
                                    <label>Email</label>
                                    <input type="email" class="form-control" v-model="userData.email">
                                </div>
                            </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scope" aria-expanded="false" aria-controls="scope">
                    Social Links
                  </button>
                </h2>
                <div id="scope" class="accordion-collapse collapse" >
                  <div class="accordion-body">
                    <font-awesome-icon :icon="['fas', 'square-plus']"
                                @click="userData.socialLinks.push({ name: null, link: null })" />
                            <div class="">
                                <div class="" v-for="(rr, ind) in userData.socialLinks" :key="ind">
                                    <a :href="rr.link" ><font-awesome-icon :icon="getIcon(rr.name)" /></a>
                                </div>
                                <div class="input-group flex-nowrap my-2" v-for="(rr, ind) in userData.socialLinks"
                                    :key="ind">
                                    <input type="text" class="form-control mr-2"
                                        v-model="userData.socialLinks[ind].link" placeholder="Link" aria-label=""
                                        aria-describedby="addon-wrapping">
                                    <div class="input-group-append">
                                        <select class="form-control" v-model="userData.socialLinks[ind].name">
                                            <option v-for="(r, i) in rs" :key="i" :value="r[0]">
                                                <span>
                                                    <font-awesome-icon :icon="r[1]" />
                                                </span>
                                                <span v-html="r[0]"></span>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center ml-1"
                                        @click="userData.socialLinks.splice(ind, 1)">
                                        <font-awesome-icon :icon="['far', 'trash-can']" />
                                    </div>
                                </div>
                            </div> <!-- end col -->
                  </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" >
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#summarydiv" aria-expanded="false" aria-controls="summarydiv">
                    Stats 
                  </button>
                </h2>
                
                <div id="summarydiv" class="accordion-collapse collapse" >
                  <div class="accordion-body">
                    <div class="card mb-0" v-if="userData.role && userData.role.name == 'Auditor'">
                    <div class="card-header" id="headingFour">
                        <h5 class="m-0 font-size-15">
                            <a class="collapsed d-block pt-2 pb-2 text-dark" data-toggle="collapse"
                                href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">

                                Stats <span class="float-right"><svg class="svg-icon" viewBox="0 0 20 20">
							<path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
						</svg></span>
                            </a>
                        </h5>
                    </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Auditor Projects ({{ userProjects['Auditor'] ? userProjects['Auditor'].length : 0 }})</label>
                                <select name="" id="" class="form-control" v-if="userProjects['Auditor'] && userProjects['Auditor'].length > 0">
                                    <option v-for="(p, i) in userProjects['Auditor']" :key="i" :value="p.id">
                                        {{ p.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label>Lead Auditor Projects ({{ userProjects['Lead Auditor'] ? userProjects['Lead Auditor'].length : 0  }}) </label>
                                <select name="" id="" class="form-control" v-if="userProjects['Lead Auditor'] && userProjects['Lead Auditor'].length > 0">
                                    <option v-for="(p, i) in userProjects['Lead Auditor']" :key="i" :value="p.id">
                                        {{ p.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                  
                </div> <!-- end card-->
                   </div>
                </div>
            </div>
        
         
          
        </div>
                </div> <!-- end card-->

                
                
            </div> <!-- end custom accordions-->
        </div> <!-- end col -->
        <div class="col-lg-8">
            <div class="d-flex card" style="display: flex; flex-direction: row;">
                <div class="divSkills" v-if="userData.skills">
                    <h3 class="title">Skills</h3>
                    <skillsChart :skills="userData.skills"></skillsChart>
                </div>
                <div class="" v-if="userData.stats">
                    <h3 class="title">Issues</h3>
                    <issuesChart :stats="userData.stats"></issuesChart>
                </div>
            </div>
        </div>
    </div>

   
</template>



<style>
/* -----
SVG Icons - svgicons.sparkk.fr
----- */
.title {
    color: black;
}
.svg-icon {
  width: 1.3em;
  height: 1.3em;
}

.svg-icon path,
.svg-icon polygon,
.svg-icon rect {
  fill: #fb5400;
}

.svg-icon circle {
  stroke: #ee0e06;
  stroke-width: 1;
}
.view01{
    margin-top: 6%;
}
.divSkills{
   width: 80%;
}
.fnt{
    font-family: 'Poppins', sans-serif;
}
.divInfo{
    margin-top: 100%;
}
.nav-pills .nav-link {
  color: var(--whiteColor);
  border-radius: 0;
}

.nav-pills .nav-link.active {
  background-color: var(--navActive);
}

.nav-pills .nav-item,
.tab-content {
  border: solid 0.5px var(--borderCard);
}

.tab-content {
  background-color: var(--navBg);
  border-radius: 0;
  min-height: 50vh;
}

</style>
