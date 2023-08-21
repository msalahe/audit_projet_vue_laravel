<template>
        <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#issue-'+issue.id" aria-expanded="true" :aria-controls="'issue-'+issue.id">
               <div class="row mx-0 w-100">
                <h5 class="col-xl-10"><span :class="'badge rounded-pill me-2 issue-'+issue.severity">{{issue.code}} </span> {{issue.title }}</h5>
               <div class="col-xl-2 text-end"><badge class="badge p-2 " v-bind:style="{backgroundColor:stateColor}">{{issue.state}}</badge></div>
           
               </div>
                 </button>
            </h2>
            <div :id="'issue-'+issue.id" class="accordion-collapse collapse">
              <div class="accordion-body">
                <div class="row mx-0">
                    <div class="col-xl-6 mb-2">
                        <label  class="col-form-label">Title</label>
                        <input type="text" class="form-control" :value="issue.title" @input="issue.title = $event.target.value">
                    </div>
                    <div class="col-xl-3 mb-2">
                        <label  class="col-form-label">Likelihood</label>
                        <select class="form-select" :value="issue.likelihood" @change="issue.likelihood = $event.target.value">
                            <option  :value="1">HIGH</option>
                            <option  :value="2">MEDIUM</option>
                            <option  :value="3">LOW</option>
                        </select>
                    </div>
                    <div class="col-xl-3 mb-2">
                        <label  class="col-form-label">Impact</label>
                        <select class="form-select" :value="issue.impact" @change="issue.impact = $event.target.value">
                            <option  :value="1">HIGH</option>
                            <option  :value="2">MEDIUM</option>
                            <option  :value="3">LOW</option>
                        </select>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-6 mb-2">
                        <label  class="col-form-label">Status</label>
                        <select class="form-select" :value="issue.status" @change="issue.status = $event.target.value">
                            <option selected disabled>Status</option>
                            <option  v-for="(item,index) in status" :key="index" :value="item">{{item}}</option>
                          </select>
                    </div>
                    <div class="col-xl-6 mb-2">
                        <label  class="col-form-label">Auditor</label>
                        <input type="text" class="form-control" :value="issue.user.full_name" disabled>
                    </div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-xl-12 mb-2">
                            <label  class="col-form-label">Description</label>
                            <textarea rows="4" class="form-control" :value="issue.description"  @input="issue.description = $event.target.value"></textarea>
                        </div>
                        </div>
                        <div class="row mx-0">
                        <div class="col-xl-12 mb-2">
                            <label  class="col-form-label">Exploit Scenario</label>
                            <textarea rows="4" class="form-control" :value="issue.exploit_scenario"  @input="issue.exploit_scenario = $event.target.value"></textarea>
                        </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-xl-8">
                                <label  class="col-form-label">Affected Files</label>
                                <input type="text" class="form-control" >
          
                            </div>
                            <div class="col-xl-2">
                                <label  class="col-form-label">S.Line</label>
                                <input type="number" min="1" class="form-control" >
                            </div>
                            <div class="col-xl-2 text-end add">
                                <i class="fas fa-plus-circle fa-2x"></i>
                            </div>
                        </div>
                        <div class="row mx-0">
                        <div class="col-xl-12 mb-2">
                            <label  class="col-form-label">Recommendation</label>
                            <textarea rows="4" class="form-control" :value="issue.recommendation"  @input="issue.recommendation = $event.target.value"></textarea>
                        </div>
                        </div>
                        <div class="row mx-0">
                        <div class="col-xl-12 mb-2" v-if="issue.status != 'Not Fixed'">
                            <label  class="col-form-label">Updates</label>
                            <textarea rows="4" class="form-control" :value="issue.updates"  @input="issue.updates = $event.target.value"></textarea>
                        </div>
                        </div>
                    
                <div class="row mx-0 my-3">
                    <div class="col-xl-3 mb-2">
                        <select class="form-select form-custom text-white" v-bind:style="{backgroundColor:stateColor}"   :value="issue.state" @change="issue.state = $event.target.value">
                            <option selected disabled>State</option>
                            <option  v-for="(item,index) in states" :key="index" :value="item.name">{{item.name}}</option>
                          </select>
                    </div>
                    <div class="col-xl-5 mb-2 ms-auto text-end">
                       <button class="btn btn-danger mx-1">Delete</button>
                       <button class="btn btn-success mx-1">Save</button>
                    </div>

                </div>
              </div>
            </div>
          </div>
</template>

<script>

    export default {
        name: "IssueSection",
        props:['issue_p','status'],
        data(){
            return {
                issue:this.issue_p,
                states:[
              {
                name:'Draft',
                color:'#aaa'
              },
               {
                name:'Pending',
                color:'#412089'
              },
               {
                name:'Fixes',
                color:'#75B0FE'
              },
               {
                name:'Duplicated',
                color:'#1E133D'
              },
               {
                name:'Approved',
                color:'#0f0'
              },
              {
                name:'Not Approved',
                color:'#f00'
              }
            ],
            }
        },
        computed:{
            stateColor:function(){
               return this.states[this.states.findIndex(x => x.name == this.issue.state)].color;

            }
        }

       
      
      
    }
</script>

<style scoped>
.form-custom  {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}
.add{
    align-items: flex-end;
    display: flex;
    justify-content: center;
    margin-bottom: 12px;
    cursor:pointer;
}
.accordion-item{
	box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}
.accordion-collapse{
    background-color: var(--themeBg);

}

.accordion-button{
    background-color: var(--themeBg);
    color:var(--whiteColor);
}
.accordion-item{
    color:var(--whitecolor);
}
.accordion-button:not(.collapsed){
     background-color: var(--accordianActive);
}
.accordion-button.collapsed::after {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}
.form-control,.form-select{
	color: var(--whiteColor);
	border:none;
	padding: 12px;
    background-color: var(--navBg);
}
.form-select{
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}
</style>