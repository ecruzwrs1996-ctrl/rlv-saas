<template>

<div class="chart-card">

    <div class="chart-header">

        <h3>
            Residents Analytics
        </h3>

    </div>

    <div class="chart-container">

        <Bar
            :data="chartData"
            :options="chartOptions"
        />

    </div>

</div>

</template>

<script setup>

import {

    computed

} from 'vue'

import {

    Chart as ChartJS,

    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale

} from 'chart.js'

import {

    Bar

} from 'vue-chartjs'

ChartJS.register(

    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
)

const props = defineProps({

    stats: {
        type: Object,
        required: true
    }
})

const chartData = computed(() => ({

    labels: [

        'Residents',
        'Streets',
        'Users',
        'Guards'
    ],

    datasets: [

        {

            label: 'Analytics',

            data: [

                props.stats.totalResidents,

                props.stats.totalStreets,

                props.stats.totalUsers,

                props.stats.activeGuards
            ]
        }
    ]
}))

const chartOptions = {

    responsive: true,

    maintainAspectRatio: false
}

</script>

<style scoped>

.chart-card {

    background: white;

    border-radius: 16px;

    padding: 24px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.chart-header {

    margin-bottom: 20px;
}

.chart-container {

    height: 350px;
}

</style>