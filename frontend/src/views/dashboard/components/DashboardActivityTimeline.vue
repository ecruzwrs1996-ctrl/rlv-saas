<template>

<div class="chart-card">

    <div class="chart-header">

        <div>

            <h3>
                Activity Timeline
            </h3>

            <p>
                Today's user sessions
            </p>

        </div>

    </div>

    <div
        v-if="loading"
        class="loading"
    >

        Loading timeline...

    </div>

    <div
        v-else
        class="chart-container"
    >

        <Bar
            :data="chartData"
            :options="chartOptions"
        />

    </div>

</div>

</template>

<script setup>

import {

    ref,
    computed,
    onMounted

} from 'vue'

import dashboardService
from '@/services/dashboard.service'

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

/**
 * State
 */

const loading = ref(false)

const timeline = ref([])

/**
 * Load timeline
 */

async function loadTimeline()
{
    loading.value = true

    try {

        const response =
            await dashboardService
                .getActivityTimeline()

        timeline.value =
            response.data

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
    }
}

/**
 * Chart Data
 */

const chartData = computed(() => {

    return {

        labels:

            timeline.value.map(

                item => item.username
            ),

        datasets: [

            {

                label:
                    'Hours Connected',

                data:

                    timeline.value.map(

                        item =>
                            Number(
                                item.total_hours
                            )
                    ),

                backgroundColor: [

                    '#111827',
                    '#374151',
                    '#6B7280'
                ]
            }
        ]
    }
})
/**
 * Chart Options
 */

const chartOptions = {

    responsive: true,

    maintainAspectRatio: false,

    plugins: {

        legend: {

            display: true
        }
    },

    scales: {

        y: {

            beginAtZero: true,

            min: 0,

            suggestedMax: 12,

            ticks: {

                stepSize: 2,

                precision: 0
            },

            title: {

                display: true,

                text: 'Hours'
            }
        },

        x: {

            title: {

                display: true,

                text: 'Users'
            }
        }
    }
}

/**
 * Init
 */

onMounted(() => {

    loadTimeline()
})

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

.chart-header p {

    color: #6b7280;

    margin-top: 6px;
}

.chart-container {

    height: 350px;
}

.loading {

    padding: 20px;

    color: #6b7280;
}

</style>