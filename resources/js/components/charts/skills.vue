<script setup>
import { onMounted, computed } from 'vue'
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const props = defineProps({
    skills: Object
})
/*
 const datasets = computed(() => ({
    data: props.skills.map(skill => skill.id),
    label: props.skills.map(skill => skill.name)
})) */

const chartOptions = {
    responsive: true,
    indexAxis: 'y',
    maxBarThickness : 20,
    barPercentage  : 100
}

const chartData = computed(() => ({
    labels: props.skills.map(skill => skill.name),
    datasets: [{  label: 'Skills Level',
    data: props.skills.map(skill => skill.pivot ? skill.pivot.level : null) ,
    backgroundColor: 'rgba(0,0,0,0.5)' // add backgroundColor property here
}]
}))

onMounted(() => {
})

</script>
<template>
    <div>
        <Bar id="my-chart-id" :data="chartData" :options="chartOptions" />
    </div>
</template>


<style>

</style>
