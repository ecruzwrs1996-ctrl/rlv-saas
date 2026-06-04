<template>

<div class="actions-card">

    <h3>
        Quick Actions
    </h3>

<div class="actions-list">

    <RouterLink
        to="/directory"
        class="action-btn"
    >

        Manage Directory

    </RouterLink>

    <RouterLink
        to="/streets"
        class="action-btn"
    >

        Manage Streets

    </RouterLink>

    <RouterLink
        to="/residents"
        class="action-btn"
    >

        Manage Residents

    </RouterLink>

    <RouterLink
        to="/users"
        class="action-btn"
    >

        Manage Users

    </RouterLink>

    <RouterLink
        to="/roles"
        class="action-btn"
    >

        Manage Configurations

    </RouterLink>

    <RouterLink
        to="/audit"
        class="action-btn"
    >

        Manage Audit

    </RouterLink>

</div>

</div>

</template>

<style scoped>

.actions-card {

    background: white;

    border-radius: 16px;

    padding: 24px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.actions-list {

    display: flex;

    flex-direction: column;

    gap: 14px;

    margin-top: 20px;
}

.action-btn {

    background: #111827;

    color: white;

    text-decoration: none;

    padding: 14px;

    border-radius: 12px;

    text-align: center;

    font-weight: 600;
}

</style>