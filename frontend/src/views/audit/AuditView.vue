<template>

<div class="audit-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>

                Audit

            </h1>

            <p>

                Enterprise audit monitoring

            </p>

        </div>

    </div>

    <!-- Filters -->

    <AuditFilters

        :filters="filters"

        @search="handleSearch"
    />

    <!-- Table -->

    <AuditTable

    :logs="logs"

    :loading="loading"

    :pagination="pagination"

    :roles="roles"

    @page-change="changePage"

    @export="handleExport"

    @purge="handlePurge"
/>

</div>

</template>

<script setup>

import { ref } from 'vue'

import auditService from '@/services/audit.service'

import rolesService from '@/services/roles.service'

import AuditFilters from './components/AuditFilters.vue'

import AuditTable from './components/AuditTable.vue'

/**
 * State
 */

const logs = ref([])

const roles = ref([])

const loading = ref(false)

const pagination = ref({

    page: 1,

    perPage: 10,

    total: 0,

    totalPages: 1
})

const filters = ref({

    module: '',

    action_type: '',

    username: '',

    start_date: '',

    end_date: ''
})


/**
 * Load Roles
 */
async function loadRoles() {

    try {

        const response =
            await rolesService.getRoles()

        roles.value =
            response.data

    } catch (error) {

        console.error(error)
    }
}


/**
 * Load Audit Logs
 */

async function loadAuditLogs(page = 1) {

    loading.value = true

    try {

        const response =
            await auditService.getAuditLogs({

                page,

                perPage:
                    pagination.value.perPage,

                ...filters.value
            })

        logs.value =
            response.data.data

        pagination.value =
            response.data.pagination

    } catch (error) {

        console.error(error)
    }

    finally {

        loading.value = false
    }
}

/**
 * Search
 */

function handleSearch(newFilters) {

    filters.value = newFilters

    loadAuditLogs()
}

/**
 * Pagination
 */

function changePage(page) {

    loadAuditLogs(page)
}

/**
 * Export XLSX
 */
function handleExport() {

    const token =
        localStorage.getItem('token')

    window.open(

        `http://localhost:8080/api/audit/export?token=${token}`,

        '_blank'
    )
}

/**
 * Purge
 */

async function handlePurge() {

    try {

        const response =
            await auditService.purgeAudit()

        alert(
            response.message
        )

        await loadAuditLogs()

    } catch (error) {

        console.error(error)

        alert(
            'Error purge audit'
        )
    }
}

/**
 * Init
 */
loadRoles()

</script>

<style scoped>

.audit-page {

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;
}

</style>