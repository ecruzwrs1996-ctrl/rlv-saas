<template>

<div class="activity-card">

    <div class="card-header">

        <h3>
            Recent Activity
        </h3>

    </div>

    <div
        v-if="loading"
        class="loading"
    >

        Loading activity...

    </div>

    <div
        v-else-if="!activity.length"
        class="empty"
    >

        No activity found

    </div>

    <div
        v-else
        class="activity-list"
    >

        <div
            v-for="item in activity"
            :key="item.Id_aud_action"
            class="activity-item"
        >

            <div class="activity-badge">

                {{ item.action_type }}

            </div>

            <div class="activity-content">

                <strong>

                    {{ item.table_name }}

                </strong>

                <p>

                    {{ item.description }}

                </p>

                <small>

                    {{ item.created_at }}

                </small>

            </div>

        </div>

    </div>

</div>

</template>

<script setup>

defineProps({

    activity: {
        type: Array,
        default: () => []
    },

    loading: {
        type: Boolean,
        default: false
    }
})

</script>

<style scoped>

.activity-card {

    background: white;

    border-radius: 16px;

    padding: 24px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.card-header {

    margin-bottom: 20px;
}

.activity-list {

    display: flex;

    flex-direction: column;

    gap: 18px;
}

.activity-item {

    display: flex;

    gap: 14px;

    align-items: flex-start;
}

.activity-badge {

    background: #111827;

    color: white;

    font-size: 12px;

    padding: 6px 10px;

    border-radius: 8px;

    min-width: 70px;

    text-align: center;
}

.activity-content p {

    margin: 6px 0;
}

.activity-content small {

    color: #6b7280;
}

.loading,
.empty {

    padding: 20px;

    color: #6b7280;
}

</style>