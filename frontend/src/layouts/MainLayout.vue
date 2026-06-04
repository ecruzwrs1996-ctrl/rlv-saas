<template>

    <div class="layout">

        <AppSidebar />

        <div class="main-content">

            <AppTopbar />

            <main class="page-container">

                <RouterView />

            </main>

        </div>

    </div>

</template>

<script setup>

import AppSidebar from '@/components/layout/AppSidebar.vue'
import AppTopbar from '@/components/layout/AppTopbar.vue'

</script>

<style scoped>

.layout {

    display: flex;

    min-height: 100vh;

    background: #f3f4f6;
}

.main-content {

    flex: 1;

    display: flex;

    flex-direction: column;
}

.page-container {

    padding: 25px;
}

</style>