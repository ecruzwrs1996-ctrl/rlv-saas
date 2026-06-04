<template>

<div class="kpis-grid">

    <div class="kpi-card">

        <span class="kpi-title">

            Residents

        </span>

        <h2>

            {{ stats.totalResidents }}

        </h2>

    </div>

    <div class="kpi-card">

        <span class="kpi-title">

            Streets

        </span>

        <h2>

            {{ stats.totalStreets }}

        </h2>

    </div>

    <div class="kpi-card">

        <span class="kpi-title">

            Users

        </span>

        <h2>

            {{ stats.totalUsers }}

        </h2>

    </div>

    <div class="kpi-card">

        <span class="kpi-title">

            Active Guards

        </span>

        <h2>

            {{ stats.activeGuards }}

        </h2>

    </div>

</div>

</template>

<script setup>

defineProps({

    stats: {
        type: Object,
        required: true
    },

    loading: {
        type: Boolean,
        default: false
    }
})

</script>

<style scoped>

.kpis-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 20px;
}

.kpi-card {

    background: white;

    border-radius: 16px;

    padding: 24px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.kpi-title {

    color: #6b7280;

    font-size: 14px;
}

.kpi-card h2 {

    font-size: 36px;

    margin-top: 12px;

    font-weight: 700;
}

@media (max-width: 1024px) {

    .kpis-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }
}

@media (max-width: 640px) {

    .kpis-grid {

        grid-template-columns: 1fr;
    }
}

</style>