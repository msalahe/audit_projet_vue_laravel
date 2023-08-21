<template>
  <main class="row ">


    <div class="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#details"
            aria-expanded="true" aria-controls="details">
            Introdution
          </button>
        </h2>
        <div id="details" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <form>
              <div class="row mx-0">
                <div class="col-xl-12 mb-2">
                  <label class="col-form-label">Introdution</label>
                  <span class="default-text float-end" @click="setDefault('findings')">Default Description</span>
                  <textarea class="form-control"></textarea>
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
            Results
          </button>
        </h2>
        <div id="scope" class="accordion-collapse collapse">

          <div class="accordion-body">


            <div class="row mx-0">
              <div class="col-xl-8">
                <label class="col-form-label">Affected Files</label>
                <input type="text" class="form-control">

              </div>
              <div class="col-xl-2">
                <label class="col-form-label">S.Line</label>
                <input type="number" min="1" class="form-control">
              </div>
              <div class="col-xl-2 text-end add">
                <i class="fas fa-plus-circle fa-2x"></i>
              </div>
            </div>
            <input type="file" class="form-control" @change="handleFileUpload" />
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#data"
            aria-expanded="false" aria-controls="data">
            Show Result
          </button>
            <div class="row mx-0" id="data">
              <div class="container my-3">

                <table  class="table text-center" role="table">
                  <thead>
                    <tr>
                      <th scope="col">New Test</th>
                      <th scope="col">Status</th>

                    </tr>
                  </thead>
                  <tbody>
                      <tr  v-for="(row, index) in csvData" :key="index">
                        <td> {{ row.name }}</td>
                        <td> {{ row.status }}</td>

                      </tr>
                  </tbody>
                </table>
              </div>
            </div>




          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qas"
            aria-expanded="false" aria-controls="qas">
            Coverage
          </button>
        </h2>
        <div id="qas" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row mx-0">
              <div class="col-xl-8">
                <label class="col-form-label">Contract Name</label>
                <input type="text" class="form-control">

              </div>
              <div class="col-xl-2">
                <label class="col-form-label">Coverage %</label>
                <input type="number" min="1" class="form-control">
              </div>
              <div class="col-xl-2 text-end add">
                <i class="fas fa-plus-circle fa-2x"></i>
              </div>
            </div>
            <div>
              <apexchart width="500" type="bar" :options="chartOptions" :series="series"></apexchart>
              <div class="row mx-0">
                <div class="col-xl-12 mb-2">
                  <label class="col-form-label">Code Coverage Data</label>
                  <textarea class="form-control"></textarea>
                </div>

              </div>
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
                <span class="default-text float-end" @click="setDefault('conclusion')">Default Conclusion</span>
                <textarea class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</template>

<script setup>
import { ref } from 'vue'

const chartOptions = {
  chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      horizontal: true,
    }
  },
  dataLabels: {
    enabled: false
  },
  xaxis: {
    categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
      'United States', 'China', 'Germany'
    ],
  }
};
const series = [{
  data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
}];

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
.add {
  align-items: flex-end;
  display: flex;
  justify-content: center;
  margin-bottom: 12px;
  cursor: pointer;
}

.default-text {
  font-size: 14px;
  color: var(--grayColor);
  cursor: pointer;
}

.accordion-collapse {
  background-color: var(--navBg);
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



.form-select {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}</style>