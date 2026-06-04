<template>

<div class="stats-card">

    <h3>
        Analytics Overview
    </h3>

    <div class="stats-grid">

        <div class="stat-box">

            <span>
                Residents
            </span>

            <strong>
                {{ stats.totalResidents }}
            </strong>

        </div>

        <div class="stat-box">

            <span>
                Streets
            </span>

            <strong>
                {{ stats.totalStreets }}
            </strong>

        </div>

        <div class="stat-box">

            <span>
                Users
            </span>

            <strong>
                {{ stats.totalUsers }}
                
            </strong>


            <strong>
    {{ stats.totalUsers }}
</strong>

<span>
    Total Users
</span>

        </div>

        <div class="stat-box">

            <span>
                Guards
            </span>

            <strong>
                {{ stats.activeGuards }}
            </strong>

        </div>

    </div>

</div>

</template>

<script setup>

defineProps({

    stats: {
        type: Object,
        required: true
    }
})

</script>

<style scoped>

.stats-card {

    background: white;

    border-radius: 16px;

    padding: 24px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.stats-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

    margin-top: 20px;
}

.stat-box {

    background: #f9fafb;

    border-radius: 12px;

    padding: 20px;

    display: flex;

    flex-direction: column;

    gap: 10px;
}

.stat-box span {

    color: #6b7280;
}

.stat-box strong {

    font-size: 28px;
}

</style>