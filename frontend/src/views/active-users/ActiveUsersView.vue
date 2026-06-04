
<template>

<div class="active-users-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>
                Active Users Realtime
            </h1>

            <p>
                Live sessions monitoring
            </p>

        </div>

        <div class="live-badge">

            LIVE

        </div>

    </div>

    <!-- KPI CARDS -->

    <div class="stats-grid">

        <div class="stat-card online">

            <div class="stat-value">

                {{ stats.online_users }}

            </div>

            <div class="stat-label">

                Online Users

            </div>

        </div>

        <div class="stat-card sessions">

            <div class="stat-value">

                {{ stats.closed_sessions }}

            </div>

            <div class="stat-label">

                Closed Sessions

            </div>

        </div>

        <div class="stat-card logins">

            <div class="stat-value">

                {{ stats.logins_today }}

            </div>

            <div class="stat-label">

                Total Logins Today

            </div>

        </div>

        <div class="stat-card active">

            <div class="stat-value">

                {{ stats.active_users_today }}

            </div>

            <div class="stat-label">

                Active Users Today

            </div>

        </div>

    </div>

    <!-- CONTENT GRID -->

    <div class="content-grid">

        <!-- ONLINE USERS -->

        <div class="users-panel">

            <div class="panel-header">

                <h2>
                    Users Connected
                </h2>

            </div>

            <div
                v-if="onlineUsers.length"
                class="users-list"
            >

                <div
                    v-for="user in onlineUsers"
                    :key="user.Id_usr_session"
                    class="user-card"
                >

                    <!-- Avatar -->

                    <div
                        class="avatar"
                        :class="getRoleClass(user.Role_id)"
                    >

                        {{ user.username.charAt(0) }}

                    </div>

                    <!-- User Info -->

                    <div class="user-info">

                        <strong>

                            {{ user.username }}

                        </strong>

                        <small>

                            {{ user.email }}

                        </small>

                        <span
                            class="role-badge"
                            :class="
                                getRoleClass(
                                    user.Role_id
                                )
                            "
                        >

                            {{ getRoleName(user.Role_id) }}

                        </span>

                    </div>

                    <!-- Status -->

                    <div class="online-status">

                        <span class="pulse"></span>

                        Online

                    </div>

                </div>

            </div>

            <div
                v-else
                class="empty-state"
            >

                No active users

            </div>

        </div>

        <!-- LOGIN CHART -->

        <div class="chart-panel">

            <div class="panel-header">

                <h2>

                    Logins Per User

                </h2>

            </div>

            <canvas
                ref="chartCanvas"
                height="280"
            ></canvas>

        </div>

    </div>

</div>

</template>

<script setup>

import {

    ref,

    onMounted,

    onBeforeUnmount,

    nextTick

} from 'vue'

import Chart from 'chart.js/auto'

import activeUsersService
    from '@/services/active-users.service'

/**
 * State
 */

const stats = ref({

    online_users: 0,

    closed_sessions: 0,

    logins_today: 0,

    active_users_today: 0
})

const onlineUsers = ref([])

const chartData = ref([])

const chartCanvas = ref(null)

let chartInstance = null

let refreshInterval = null

/**
 * Load dashboard
 */

async function loadDashboard() {

    try {

        const response =
            await activeUsersService
                .getDashboardData()

        const data =
            response.data

        stats.value =
            data.stats

        onlineUsers.value =
            data.online_users

        chartData.value =
            data.chart

        await nextTick()

        renderChart()

    } catch (error) {

        console.error(error)
    }
}

/**
 * Chart
 */

function renderChart() {

    if (!chartCanvas.value)
        return

    /**
     * Destroy old chart
     */

    if (chartInstance) {

        chartInstance.destroy()
    }

    chartInstance = new Chart(

        chartCanvas.value,

        {

            type: 'bar',

            data: {

                labels:
                    chartData.value.map(

                        item =>
                            item.username
                    ),

                datasets: [

                    {

                        label:
                            'Logins Today',

                        data:
                            chartData.value.map(

                                item =>
                                    item.total_logins
                            ),

                        borderWidth: 2,

                        borderRadius: 10
                    }
                ]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        display: false
                    }
                },

                scales: {

                    y: {

                        beginAtZero: true
                    }
                }
            }
        }
    )
}

/**
 * Role helpers
 */

function getRoleName(roleId) {

    switch (Number(roleId)) {

        case 1:
            return 'SYS'

        case 2:
            return 'ADM'

        case 3:
            return 'GUA'

        default:
            return 'USER'
    }
}

function getRoleClass(roleId) {

    switch (Number(roleId)) {

        case 1:
            return 'sys'

        case 2:
            return 'adm'

        case 3:
            return 'gua'

        default:
            return 'default'
    }
}

/**
 * Lifecycle
 */

onMounted(async () => {

    await loadDashboard()

    /**
     * Auto refresh realtime
     */

    refreshInterval =
        setInterval(

            loadDashboard,

            5000
        )
})

onBeforeUnmount(() => {

    if (refreshInterval) {

        clearInterval(
            refreshInterval
        )
    }

    if (chartInstance) {

        chartInstance.destroy()
    }
})

</script>

<style scoped>

.active-users-page {

    display: flex;

    flex-direction: column;

    gap: 24px;
}

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.page-header h1 {

    margin: 0;

    font-size: 32px;
}

.page-header p {

    color: #6b7280;

    margin-top: 4px;
}

.live-badge {

    background: #dc2626;

    color: white;

    padding: 10px 18px;

    border-radius: 999px;

    font-weight: 700;

    animation: pulse-live 1.5s infinite;
}

@keyframes pulse-live {

    0% {

        opacity: 1;
    }

    50% {

        opacity: 0.5;
    }

    100% {

        opacity: 1;
    }
}

.stats-grid {

    display: grid;

    grid-template-columns:
        repeat(auto-fit, minmax(220px, 1fr));

    gap: 20px;
}

.stat-card {

    background: white;

    border-radius: 18px;

    padding: 24px;

    box-shadow:
        0 4px 14px rgba(0,0,0,0.06);

    display: flex;

    flex-direction: column;

    gap: 10px;
}

.stat-value {

    font-size: 38px;

    font-weight: 700;
}

.stat-label {

    color: #6b7280;

    font-size: 14px;
}

.online {

    border-left: 6px solid #10b981;
}

.sessions {

    border-left: 6px solid #6366f1;
}

.logins {

    border-left: 6px solid #2563eb;
}

.active {

    border-left: 6px solid #f59e0b;
}

.content-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 24px;
}

.users-panel,
.chart-panel {

    height: 420px;

    max-height: 420px;

    overflow: hidden;
}

.chart-panel canvas {

    width: 100% !important;

    height: 320px !important;
}


.panel-header {

    margin-bottom: 20px;
}

.users-list {

    display: flex;

    flex-direction: column;

    gap: 16px;
}

.user-card {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 16px;

    padding: 16px;

    border-radius: 14px;

    background: #f9fafb;
}

.avatar {

    width: 52px;

    height: 52px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    font-weight: 700;

    font-size: 20px;
}

.avatar.sys {

    background: #dc2626;
}

.avatar.adm {

    background: #2563eb;
}

.avatar.gua {

    background: #16a34a;
}

.user-info {

    flex: 1;

    display: flex;

    flex-direction: column;

    gap: 6px;
}

.user-info small {

    color: #6b7280;
}

.role-badge {

    width: fit-content;

    padding: 4px 10px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 700;

    color: white;
}

.role-badge.sys {

    background: #dc2626;
}

.role-badge.adm {

    background: #2563eb;
}

.role-badge.gua {

    background: #16a34a;
}

.online-status {

    display: flex;

    align-items: center;

    gap: 8px;

    color: #16a34a;

    font-weight: 600;
}

.pulse {

    width: 10px;

    height: 10px;

    border-radius: 50%;

    background: #16a34a;

    animation: pulse-dot 1s infinite;
}

@keyframes pulse-dot {

    0% {

        transform: scale(1);
    }

    50% {

        transform: scale(1.5);
    }

    100% {

        transform: scale(1);
    }
}

.empty-state {

    text-align: center;

    padding: 40px;

    color: #6b7280;
}

.chart-panel {

    min-height: 420px;
}

@media (max-width: 992px) {

    .content-grid {

        grid-template-columns: 1fr;
    }
}

</style>

