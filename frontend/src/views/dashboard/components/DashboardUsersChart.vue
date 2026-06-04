<template>

<div class="chart-card">

    <div class="chart-header">

        <h3>
            Users Distribution
        </h3>

    </div>

    <div class="chart-container">

        <Doughnut
            :data="chartData"
            :options="chartOptions"
        />

    </div>

<div class="roles-distribution">

    <div
        v-for="role in stats.rolesDistribution"
        :key="role.role"
        class="role-item"
    >

        <strong>

   

    {{ role.role }}

   

</strong>

        <span>
          
        </span>

        <small>

    Permissions -> 

    {{ role.label }}

</small>

    </div>

</div>


</div>

</template>

<script setup>

import {

    computed

} from 'vue'

import {

    Chart as ChartJS,

    ArcElement,
    Tooltip,
    Legend

} from 'chart.js'

import {

    Doughnut

} from 'vue-chartjs'

ChartJS.register(

    ArcElement,
    Tooltip,
    Legend
)

const props = defineProps({

    stats: {
        type: Object,
        required: true
    }
})

const chartData = computed(() => ({

    labels:

        (props.stats.rolesDistribution || []).map(

            role => role.role
        ),

    datasets: [

        {

        backgroundColor: [

    '#7F1D1D', // SYS
    '#2563eb', // ADM
    '#10b981'  // GUA
],

            data:

                (props.stats.rolesDistribution || []).map(

                    role => role.total
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