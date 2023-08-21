<template>
    <main class="row ">


          <div class="accordion">
           
        
            <div class="accordion-item">
               
                <div id="qas" class="accordion-collapse" >
                  <div class="accordion-body" style="margin-left: 2%;">
                   
                        <div>
                         <apexchart
                           width="500"
                           type="bar"
                          :options="chartOptions"
                           :series="series"
                         ></apexchart>
                       
                         
                </div>           
                <div>
                   <apexchart type="donut" 
                   width="380" 
                   :options="chartOptions1" 
                   :series="series1"></apexchart>

                       
                         
                </div>    
                <div>
                  <apexchart type="area"
                   height="350" 
                   :options="chartOptions2" 
                   :series="series2"></apexchart>

                       
                         
                </div>     
                 
                 </div>
                </div>
            </div>
         
        </div>
      
    </main>
</template>

<script setup>
const  chartOptions =  {
            chart: {
              type: 'bar',
              height: 350,
              stacked: true,
              toolbar: {
                show: true
              },
              zoom: {
                enabled: true
              }
            },
            responsive: [{
              breakpoint: 480,
              options: {
                legend: {
                  position: 'bottom',
                  offsetX: -10,
                  offsetY: 0
                }
              }
            }],
            plotOptions: {
              bar: {
                horizontal: false,
                borderRadius: 10,
                dataLabels: {
                  total: {
                    enabled: true,
                    style: {
                      fontSize: '13px',
                      fontWeight: 900
                    }
                  }
                }
              },
            },
            xaxis: {
              type: 'datetime',
              categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
                '01/05/2011 GMT', '01/06/2011 GMT'
              ],
            },
            legend: {
              position: 'right',
              offsetY: 40
            },
            fill: {
              opacity: 1
            }
          };
          const  series= [{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43]
          }, {
            name: 'PRODUCT B',
            data: [13, 23, 20, 8, 13, 27]
          }, {
            name: 'PRODUCT C',
            data: [11, 17, 15, 15, 21, 14]
          }, {
            name: 'PRODUCT D',
            data: [21, 7, 25, 13, 22, 8]
          }];
        
        const  chartOptions1 = {
            chart: {
              width: 380,
              type: 'donut',
            },
            plotOptions: {
              pie: {
                startAngle: -90,
                endAngle: 270
              }
            },
            dataLabels: {
              enabled: false
            },
            fill: {
              type: 'gradient',
            },
            legend: {
              formatter: function(val, opts) {
                return val + " - " + opts.w.globals.series[opts.seriesIndex]
              }
            },
            title: {
              text: 'Gradient Donut with custom Start-angle'
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
          };
          const  series1= [44, 55, 41, 17, 15];
          const  chartOptions2 = {
            chart: {
              height: 350,
              type: 'area'
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'smooth'
            },
            xaxis: {
              type: 'datetime',
              categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
            },
            tooltip: {
              x: {
                format: 'dd/MM/yy HH:mm'
              },
            },
          };
          const  series2=  [{
            name: 'series1',
            data: [31, 40, 28, 51, 42, 109, 100]
          }, {
            name: 'series2',
            data: [11, 32, 45, 32, 34, 52, 41]
          }];
       
      
      
    
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped src="@/../css/table.css"></style>

<style scoped>
.add{
    align-items: flex-end;
    display: flex;
    justify-content: center;
    margin-bottom: 12px;
    cursor:pointer;
}
.default-text{
    font-size: 14px;
    color: var(--grayColor);
    cursor: pointer;
}
.accordion-collapse{
    background-color: var(--navBg);
}

.accordion-button{
    background-color: var(--secondColor);
    color:var(--whiteColor);
}
.accordion-item{
    color:var(--whitecolor);
    border-color:var(--popupBg);
}
.accordion-button:not(.collapsed){
     background-color: var(--navActive);
}
/* /deep/.multiselect-option{
    color:var(--popupBg)!important;
} */
.form-control,.form-select,.multiselect{
	color: var(--whiteColor);
	padding: 12px;
	border:none;
    background-color: var(--themeBg);
}
.form-control,.form-select{
	color-scheme: dark;
}

 .multiselect-tags-search,.multiselect-dropdown{
	background: var(--themeBg)!important;
    color: var(--whiteColor)!important;
}



.form-select{
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='white' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
}
</style>