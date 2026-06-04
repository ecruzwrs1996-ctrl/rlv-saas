<template>

<div class="dashboard-page">

    <!-- Header -->

    <div class="dashboard-header">

        <div>

            <h1>
                Analytics
            </h1>

            <p>
              Residential Control 
            </p>

        </div>

    </div>

    <!-- ROW 1 -->

    <div class="dashboard-row">

        <div class="dashboard-card large">

            <DashboardStats
                :stats="stats"
            />

        </div>

        <div class="dashboard-card">

            <DashboardResidentsChart
                :stats="stats"
            />

        </div>

    </div>

    <!-- ROW 2 -->

    <div class="dashboard-row">

        <div class="dashboard-card">

            <DashboardUsersChart
                :stats="stats"
            />

        </div>

        <div class="dashboard-card">

            <DashboardActivityTimeline />

        </div>

    </div>

    <!-- ROW 3 -->

    <div class="dashboard-row">

        <div class="dashboard-card">

            <DashboardActivity
                :activity="activity.slice(0, 3)"
                :loading="loading"
            />

            <!-- Pagination Fake -->

           <div class="activity-actions">

    <RouterLink
        to="/audit"
        class="btn-audit"
    >

        Go Audit

    </RouterLink>

</div>

        </div>

        <div class="dashboard-card small">

            <DashboardQuickActions />

        </div>

    </div>

</div>

</template>

<script setup>

import {

    ref,
    onMounted

} from 'vue'

import dashboardService
from '@/services/dashboard.service'

import DashboardStats
from './components/DashboardStats.vue'

import DashboardActivity
from './components/DashboardActivity.vue'

import DashboardQuickActions
from './components/DashboardQuickActions.vue'

import DashboardResidentsChart
from './components/DashboardResidentsChart.vue'

import DashboardUsersChart
from './components/DashboardUsersChart.vue'

import DashboardActivityTimeline
from './components/DashboardActivityTimeline.vue'



/**
 * State
 */

const loading = ref(false)

const stats = ref({

    totalResidents: 0,

    totalStreets: 0,

    totalUsers: 0,

    activeGuards: 0
})

const activity = ref([])

/**
 * Load Dashboard
 */

async function loadDashboard() {

    loading.value = true

    try {

        /**
         * Stats
         */

        const statsResponse =
            await dashboardService
                .getStats()

        stats.value =
            statsResponse.data

        /**
         * Activity
         */

        const activityResponse =
            await dashboardService
                .getActivity()

        activity.value =
            activityResponse.data

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
    }
}

/**
 * Init
 */

onMounted(() => {

    loadDashboard()
})

</script>

<style scoped>

.dashboard-page {

    display: flex;

    flex-direction: column;

    gap: 24px;
}

.dashboard-header h1 {

    font-size: 32px;

    font-weight: 700;

    margin-bottom: 6px;
}

.dashboard-header p {

    color: #6b7280;
}

/*
|--------------------------------------------------------------------------
| ROWS
|--------------------------------------------------------------------------
*/

.dashboard-row {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 24px;
}

/*
|--------------------------------------------------------------------------
| Cards
|--------------------------------------------------------------------------
*/

.dashboard-card {

    background: white;

    border-radius: 16px;

    padding: 20px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);

    min-height: 320px;

    overflow: hidden;
}

.dashboard-card.large {

    min-height: 360px;
}

.dashboard-card.small {

    min-height: 280px;
}

/*
|--------------------------------------------------------------------------
| Activity Audit
|--------------------------------------------------------------------------
*/

.activity-actions {

    display: flex;

    justify-content: flex-end;

    margin-top: 16px;
}

.btn-audit {

    border: none;

    background: #111827;

    color: white;

    padding: 10px 16px;

    border-radius: 10px;

    text-decoration: none;

    font-weight: 600;

    transition: 0.2s;
}

.btn-audit:hover {

    background: #2563eb;
}
/*
|--------------------------------------------------------------------------
| Responsive
|--------------------------------------------------------------------------
*/

@media (max-width: 1200px) {

    .dashboard-row {

        grid-template-columns: 1fr;
    }
}

</style>