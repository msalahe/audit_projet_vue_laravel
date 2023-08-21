<template>
  <main class="row ">


    <div class="accordion" v-if="drapo">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#details"
            aria-expanded="true" aria-controls="details">
            Project Details
          </button>
        </h2>
        <div id="details" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <form>
              <div class="row mx-0">
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Project Name</label>
                  <input type="text" :value="auditStore.data.projet.summary.detail.name"
                    @input="auditStore.data.projet.summary.detail.name = $event.target.value" class="form-control">
                </div>
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Client Name</label>
                  <input type="text" :value="auditStore.data.projet.summary.detail.client_name"
                    @input="auditStore.data.projet.summary.detail.client_name = $event.target.value" class="form-control">
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Start Date</label>
                  <input type="date" class="form-control" :value="auditStore.data.projet.summary.detail.start_date"
                    @input="auditStore.data.projet.summary.detail.start_date = $event.target.value">
                </div>
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Finish Date</label>
                  <input type="date" class="form-control" :value="auditStore.data.projet.summary.detail.finish_date"
                    @input="auditStore.data.projet.summary.detail.finish_date = $event.target.value">
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Jira Id</label>
                  <input type="text" class="form-control" :value="auditStore.data.projet.summary.detail.jira_id"
                    @input="auditStore.data.projet.summary.detail.jira_id = $event.target.value" disabled>
                </div>
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Slack Channel</label>
                  <input type="text" class="form-control" :value="auditStore.data.projet.summary.detail.slack_channel"
                    @input="auditStore.data.projet.summary.detail.slack_channel = $event.target.value" disabled>
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-12 mb-2">
                  <label class="col-form-label">Description</label>
                  <textarea class="form-control" :value="auditStore.data.projet.summary.detail.description"
                    @input="auditStore.data.projet.summary.detail.description = $event.target.value"></textarea>
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-12 mb-2">
                  <label class="col-form-label">Tags</label>
                  <Multiselect mode="tags" :value="tagsDefault" :multiple="true" @select="onOptionSelectTags"
                    :options="tgs" />
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Status</label>
                  <select class="form-select" :value="auditStore.data.projet.summary.detail.status"
                    @input="auditStore.data.projet.summary.detail.status = $event.target.value">
                    <option selected disabled>Status</option>
                    <option v-for="(item, index) in status" :key="index" :value="item.id">{{ item.name }}</option>

                  </select>
                </div>
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Type</label>
                  <select class="form-select" :value="auditStore.data.projet.summary.detail.type"
                    @input="auditStore.data.projet.summary.detail.type = $event.target.value">
                    <option selected disabled>Type</option>
                    <option v-for="(item, index) in types" :key="index" :value="item.name">{{ item.name }}</option>

                  </select>
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Languages</label>
                  <Multiselect mode="tags" :value="LangDefault" :multiple="true" @select="onOptionSelectLanguages"
                    :options="languages" />


                </div>
                <div class="col-xl-6 mb-2">
                  <label class="col-form-label">Blockchain</label>

                  <Multiselect mode="tags" :value="blockchainsDefault" :multiple="true" @select="onOptionSelectBlockains"
                    :options="blockchains" />
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scope"
            aria-expanded="false" aria-controls="scope">
            Project Scope
          </button>
        </h2>
        <div id="scope" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0 mb-2 text-end">
              <div class="d-flex align-items-start mb-2 ">
                <div class="row mx-0 mb-2  " v-for="et in etat" :key="et.id">
                  <div class="col-xl-2 mb-2 ">
                    <button class="btn btn-light" type="button" :class="{ 'active': projetScope == et.name }"
                      @click="projetScope = et.name" @dblclick="updateEtat(et)">{{ et.name }}</button>
                  </div>
                </div>
                <!--<div class="col-xl-2">
                  <input type="text" v-model="statustoupdate"  class="form-control" @blur="upEtat" v-if="inputupEtat">
                </div> -->
                <div class="col-xl-2">
                  <input type="text" v-model="statustoadd" class="form-control" @keydown.enter="addEtat" v-if="inputEtat">
                </div>
                <div class="col-xl-2 text-end add">
                  <i class="fas fa-plus-circle fa-2x" @click="inputEtat = true"></i>
                </div>
              </div>


            </div>
            <div class="row mx-0">

              <div class="col-xl-2 text-end add">
                <i class="fas fa-plus-circle fa-2x" @click="auditStore.addRepos()"></i>
              </div>
              <div class="row mx-0" v-for="(rr, ind) in repo" :key="ind">


                <div class="col-xl-8">
                  <label class="col-form-label">Repos</label>
                  <input type="text" v-model="repo[ind].repos" class="form-control">

                </div>
                <div class="col-xl-2">
                  <label class="col-form-label">Commits</label>
                  <input type="text" v-model="repo[ind].commit" class="form-control">
                </div>
                <div class="col-xl-2 text-end add">
                  <i class="fas fa-minus-circle fa-2x" @click="deleteRepos(ind)"></i>
                </div>
              </div>
              <div class="row mx-6">
                <div class="row mb-2 mt-4">
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="custom-select my-1 mr-sm-2" id="lang" @change="updateExtensions()">
                        <option disabled>Choose...</option>
                        <option value=".sol" selected>Solidity (.sol)</option>
                        <option value=".rs">Rust (.rs)</option>
                        <option value=".py">PyTeal (.py)</option>
                        <option value=".teal">Teal (.teal)</option>
                        <option value=".js">JavaScript (.js)</option>
                        <option value=".ts">TypeScript (.ts)</option>
                        <option value=".sol,.rs,.py,.teal,.js,.ts">All</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group">
                      <input type="file" id="filepicker" class="form-control-file" name="fileList"
                        accept=".sol,.rs,.py,.teal,.js,.ts" webkitdirectory multiple @change="getFiles()" />
                    </div>
                  </div>
                  <input type="file" class="form-control" @change="handleFileUpload" />

                </div>
              </div>
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#data"
                aria-expanded="false" aria-controls="data">
                Show Result
              </button>
              <div class="row mx-0" id="data">
                <div class="container my-3">

                  <table class="table text-center" role="table">
                    <thead>
                      <tr>
                        <th scope="col"><input type="checkbox" v-model="allSelected" /> </th>

                        <th scope="col">File</th>
                        <th scope="col">Hash</th>

                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(file, index) in fileData" :key="index">
                        <td><input type="checkbox" :checked="allSelected ? true : false" v-model="selectedFiles"
                            :value="file" /> </td>
                        <td style="color: white;">{{ file.name }}</td>
                        <td style="color: white;">{{ file.md }}</td>

                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#summarydiv"
            aria-expanded="false" aria-controls="summarydiv">
            Summary
          </button>
        </h2>
        <div id="summarydiv" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0">
              <div class="col-xl-12 mb-2">
                <label class="col-form-label">Disclaimer:</label>
                <span class="default-text float-end" @click="auditStore.getDefault('disclaimer')">Default
                  Disclaimer</span>
                <textarea class="form-control" :value="auditStore.data.projet.summary.summary.Disclaimer"
                  @input="auditStore.data.projet.summary.summary.Disclaimer = $event.target.value"></textarea>
              </div>
            </div>
            <div class="row mx-0">
              <div class="col-xl-12 mb-2">
                <label class="col-form-label">Summary</label>
                <textarea class="form-control" :value="auditStore.data.projet.summary.summary.summary"
                  @input="auditStore.data.projet.summary.summary.Disclaimer = $event.target.value"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#findings"
            aria-expanded="false" aria-controls="findings">
            Key Fidings
          </button>
        </h2>
        <div id="findings" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0">
              <div class="col-xl-12 mb-2">
                <label class="col-form-label">Description</label>
                <span class="default-text float-end" @click="auditStore.getDefault('escription')">Default
                  Description</span>
                <textarea class="form-control" :value="auditStore.data.projet.summary.key_fiding.description"
                  @input="auditStore.data.projet.summary.key_fiding.description = $event.target.value"></textarea>
              </div>

              <div class="text-center my-2">
                <span class="badge rounded-circle bg-cri">{{ auditStore.data.stats.cri }}</span>
                <span class="badge rounded-circle bg-high">{{ auditStore.data.stats.high }}</span>
                <span class="badge rounded-circle bg-med text-dark">{{ auditStore.data.stats.med }}</span>
                <span class="badge rounded-circle bg-low">{{ auditStore.data.stats.low }}</span>
                <span class="badge rounded-circle bg-info">{{ auditStore.data.stats.info }}</span>
                <span class="badge rounded-circle bg-und">{{ auditStore.data.stats.undefined }}</span>
              </div>

            </div>
          </div>

        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qas"
            aria-expanded="false" aria-controls="qas">
            Quality Assessment
          </button>
        </h2>
        <div id="qas" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0" v-for="qa in auditStore.data.projet.summary.quality_assessment" :key="qa.id">
              <div class="col-xl-4 mb-2">
                <label class="col-form-label">Doc Name</label>
                <input type="text" class="form-control" :value="qa.name" @input="qa.name = $event.target.value">
              </div>
              <div class="col-xl-5 mb-2">
                <label class="col-form-label">Link</label>
                <input type="text" class="form-control" :value="qa.link" @input="qa.link = $event.target.value">
              </div>
              <div class="col-xl-3 mb-2">
                <label class="col-form-label">Quality</label>
                <select class="form-select" :value="qa.quality" @change="qa.quality = $event.target.value">
                  <option :value="1">HIGH</option>
                  <option :value="2">MEDIUM</option>
                  <option :value="3">LOW</option>
                </select>
              </div>
            </div>
            <div class="row mx-0 text-end mb-2">
              <button class="btn btn-light my-2"
                @click="auditStore.data.projet.summary.quality_assessment.push({ name: '', link: '', quality: 1 })">Add
                New
                QA</button>
            </div>

          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#conclusion"
            aria-expanded="false" aria-controls="conclusion">
            Conclusion
          </button>
        </h2>
        <div id="conclusion" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0">
              <div class="col-xl-12 mb-2">
                <label class="col-form-label">Conclusion</label>
                <span class="default-text float-end" @click="auditStore.getDefault('conclusion')">Default
                  Conclusion</span>
                <textarea class="form-control" :value="auditStore.data.projet.summary.conclusion"
                  @input="auditStore.data.projet.summary.conclusion = $event.target.value"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</template>

<script setup>
import Multiselect from '@vueform/multiselect'
// /audits/id/scopes
import { onMounted, reactive, ref, inject, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuditStore } from '@/stores/audit'

const auditStore = useAuditStore()
const status = ref([{ id: 1, name: 'Init' }, { id: 2, name: 'Audit' }, { id: 3, name: 'Re-Audit' }, { id: 4, name: 'Completed' }, { id: 5, name: 'Published' }, { id: 6, name: 'Fixes' }]);
const types = ref([{ id: 1, name: 'Private' }, { id: 2, name: "Public" }]);
const blockchains = ref([]);
const tgs = ref([]);
const tagsDefault = ref();
const LangDefault = ref();

const projetScope = ref("Audit");
const selectedLanguages = ref([]);
const selectedBlockains = ref([]);
const errors = reactive({ value: [] })
let inputupEtat = ref(true);
const rules = {

}


const loadFile = () => {

}

const languages = ref([]);
const etat = ref([{ id: 1, name: "Audit" }, { id: 2, name: "Re-Audit" }]);
const inputEtat = ref(false);
const statustoadd = ref();
const currentAudit = ref();

const route = useRoute();
const postId = route.params.id;
let idProjet = postId;
const getProjets = async () => {
  const response = await axios.get(`/audits/${idProjet}`)
  console.log(response.data);
}
const getTags = async () => {
  const response = await axios.get(`/tags`)
  const data = response.data;
  console.log(data);
  data.forEach(element => {
    tgs.value.push({ value: element.id, label: element.name })
  });
}
const getLanguages = async () => {
  const response = await axios.get(`/skills`)
  let data = response.data;
  console.log(response.data)

  data.forEach(element => {
    languages.value.push({ value: element.id, label: element.name })
  });
}
const addEtat = () => {
  if (statustoadd.value != undefined && statustoadd.value != "") {
    etat.value.push({ id: etat.value.length, name: statustoadd.value });
    auditStore.addEtatStore(statustoadd.value);
    statustoadd.value = "";

  }
  inputEtat.value = false;
}
const printObject = () => {
  console.log(selectedLanguages);
  console.log(selectedBlockains);

}
const fileInputRef = ref(null);
const files = ref();
const handleFileInput = () => {
  files.value = fileInputRef.value.files;
  console.log(files);
  Array.from(files).forEach(file => {
    // Do something with each file...
  });
};
let lang = [];
let drapo = ref(false);

let tabLang = ref([]);
let blockchainsDefault = ref([])
onMounted(async () => {
  await getLanguages();
  await getProjets();
  await getBlockChain();
  await getTags();
  await auditStore.getSummuaryProjet(postId);
  currentAudit.value = auditStore.data.projet;
  drapo.value = true;
  auditStore.data.projet.summary.nameScope = "Audit";
  let data = auditStore.getRepoByName("Audit");
  repo.value = data.repo;
  LangDefault.value = auditStore.data.projet.summary.detail.languagesDefault;
  blockchainsDefault.value = auditStore.data.projet.summary.detail.blockchainsDefault
  tagsDefault.value = auditStore.data.projet.summary.detail.tagsDefault

});

const getBlockChain = async () => {
  const response = await axios.get(`/blockchains`)
  let data = response.data;
  data.forEach(element => {
    blockchains.value.push({ value: element.id, label: element.name })
  });

}

/*





*/
const fileData = ref([]);
let extensions = [".sol"];
const toggle = (source) => {
  checkboxes = document.getElementsByName('pl');
  for (var checkbox of checkboxes) {
    checkbox.checked = source.checked;
  }
}

const copyResult = () => {
  let message = ''
  let msg = document.getElementById("msg");
  var markedCheckbox = document.getElementsByName('pl');
  for (var checkbox of markedCheckbox) {
    if (checkbox.checked)
      message += checkbox.value + '\n';
  }
  navigator.clipboard.writeText(message);
  // msg.innerHTML = "Success" 
  msg.style.display = "block"
  setTimeout(function () { msg.style.display = "none" }, 5000)
}

const readChunked = (file, chunkCallback, endCallback) => {
  var fileSize = file.size;
  var chunkSize = 4 * 1024 * 1024; // 4MB
  var offset = 0;

  var reader = new FileReader();
  reader.onload = function () {
    if (reader.error) {
      endCallback(reader.error || {});
      return;
    }
    offset += reader.result.length;
    // callback for handling read chunk
    // TODO: handle errors
    chunkCallback(reader.result, offset, fileSize);
    if (offset >= fileSize) {
      endCallback(null);
      return;
    }
    readNext();
  };

  reader.onerror = function (err) {
    endCallback(err || {});
  };

  function readNext() {
    var fileSlice = file.slice(offset, offset + chunkSize);
    reader.readAsBinaryString(fileSlice);
  }
  readNext();
}

const getMD5 = (blob) => {
  return new Promise((resolve, reject) => {
    var md5 = CryptoJS.algo.MD5.create();
    readChunked(blob, (chunk, offs, total) => {
      md5.update(CryptoJS.enc.Latin1.parse(chunk));

    }, err => {
      if (err) {
        reject(err);
      } else {
        // TODO: Handle errors
        var hash = md5.finalize();
        var hashHex = hash.toString(CryptoJS.enc.Hex);
        resolve(hashHex);
      }
    });
  });
}
const removeAllChildNodes = (parent) => {
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
}
const updateExtensions = () => {
  var myselect = document.getElementById("lang");
  extensions = myselect.options[myselect.selectedIndex].value.split(",")

}
const getFiles = () => {

  let files = filepicker.files;
  for (let i = 0; i < files.length; i++) {

    if (extensions.some(v => {
      let s = '.' + files[i].webkitRelativePath.split(".").pop();
      return s.includes(v)
    })) {
      getMD5(files[i]).then(
        (res) => {
          fileData.value.push({ name: files[i].name, md: res });

        },
        err => console.error(err));


    }



  };

}
const onOptionSelectTags = (option) => {
  const selectedOption = { id: option }
  auditStore.data.projet.summary.detail.tags.push(selectedOption)



}

const onOptionSelectLanguages = (option) => {
  const selectedOption = { id: option }

  auditStore.data.projet.summary.detail.languages.push(selectedOption)
}

const onOptionSelectBlockains = (option) => {
  const selectedOption = { id: option }

  auditStore.data.projet.summary.detail.blockchains.push(selectedOption)
}


let statustoupdate = ref("");
const updateEtat = (etat) => {
  statustoupdate.value = etat.name;

}
const deleteRepos = (ind) => {
  //auditStore.deleteRepos(ind);

  repo.value.splice(ind, 1);
}
let repo = ref([]);

let allSelected = ref(false);
let selectedFiles = ref([]);


watch(allSelected, (newValue) => {
  if (newValue.value == true)
    selectedFiles.value = fileData;



});


watch(
  [selectedFiles],
  ([newValue]) => {
    console.log(selectedFiles.value)
    if (newValue.length === fileData.value.length) {
      allSelected.value = true;

    } else {

      allSelected.value = false;
    }
  });

watch(
  [projetScope],
  ([newprojetScope]) => {
    auditStore.setFile(selectedFiles.value);
    auditStore.data.projet.summary.nameScope = newprojetScope;
    let data = auditStore.getRepoByName(newprojetScope);
    repo.value = data.repo;
    fileData.value = auditStore.getFiles();
  }
);

const csvData = ref([])

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  const reader = new FileReader()

  reader.onload = () => {
    const text = reader.result
    const rows = text.split('\n')
    const headers = rows[0].split(',')
    const data = []

    for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].split(',')
      const row = {}

      for (let j = 0; j < headers.length; j++) {
        row[headers[j]] = cells[j]
      }

      data.push(row)
    }

    csvData.value = data
  }

  reader.readAsText(file)
  console.log(csvData)
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped src="@/../css/table.css"></style>
<style scoped>
.default-text {
  font-size: 14px;
  color: var(--grayColor);
  cursor: pointer;
}

.accordion-collapse {
  background-color: var(--navBg);
}

.rounded-circle {
  padding: 8px 10px;
  margin: 4px 6px;
}

.accordion-button {
  background-color: var(--secondColor);
  color: var(--whiteColor);
}

.accordion-item {
  color: var(--whitecolor);
  border-color: var(--popupBg);
}

.accordion-button:not(.collapsed) {
  background-color: var(--navActive);
}

/* /deep/.multiselect-option{
    color:var(--popupBg)!important;
} */
.form-control,
.form-select,
.multiselect {
  color: var(--whiteColor);
  padding: 12px;
  border: none;
  background-color: var(--themeBg);
}

.form-control,
.form-select {
  color-scheme: dark;
}

.multiselect-tags-search,
.multiselect-dropdown {
  background: var(--themeBg) !important;
  color: var(--whiteColor) !important;
}

.add {
  align-items: flex-end;
  display: flex;
  justify-content: center;
  margin-bottom: 12px;
  cursor: pointer;
}

.form-select {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}
</style>
<style>
.multiselect-options {
  color: var(--whiteColor);
  padding: 12px;
  border: none;
  background-color: var(--themeBg);
}
</style>