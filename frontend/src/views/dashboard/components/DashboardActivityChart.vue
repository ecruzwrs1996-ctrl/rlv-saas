<template>

<div class="chart-card">

    <div class="chart-header">

        <h3>
            Activity Timeline
        </h3>

    </div>

    <div class="chart-container">

        <Line
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
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale

} from 'chart.js'

import {

    Line

} from 'vue-chartjs'

ChartJS.register(

    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale
)

const props = defineProps({

    activity: {
        type: Array,
        default: () => []
    }
})

const chartData = computed(() => ({

    labels:

        props.activity.map(

            item => item.created_at
        ),

    datasets: [

        {

            label: 'Activity',

            data:

                props.activity.map(

                    (_, index) => index + 1
                )
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