<script setup>
import { onMounted, computed } from 'vue'
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'
import ic from '@/config/ic.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

const props = defineProps({
    stats: Object
})


const chartOptions = {
    /*  responsive: true,
     indexAxis: 'y',
     maxBarThickness : 20,
     barPercentage  : 1 */
}


const chartData = computed(() => ({
    labels: Object.keys(props.stats),
    datasets: [
        {
            label: 'Count',
            data: Object.values(props.stats),
            backgroundColor: Object.keys(props.stats).map((severity) => ic[severity]),
            hoverOffset: 4
        }
    ]
}))

onMounted(() => {

})

</script>
<template>
    <div class="">
        <Pie id="my-chart-id" :data="chartData" />
    </div>
</template>


<style>

</style>
