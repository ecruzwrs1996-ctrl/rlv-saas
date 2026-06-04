<template>

<div class="directory-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>

                Directory

            </h1>

            <p>

                Residents directory module

            </p>

        </div>

    </div>

    <!-- Filters -->

  <DirectoryFilters

    :filters="filters"

    :streets="streets"

    @search="handleSearch"

    @clear="clearFilters"

    @export="handleExport"
/>

    <!-- Table -->

<!-- Empty Search State -->
<!-- Empty Search State -->

<div
    v-if="!hasSearched"
    class="empty-search-state"
>

    Apply at least one filter
    to search residents

</div>

<!-- Table -->

<DirectoryTable

    :loading="loading"

    :residents="residents"

    :pagination="pagination"

    @page-change="changePage"

    @view="openDetailModal"
/>

    <!-- Detail Modal -->

    <DirectoryDetailModal

        v-if="showDetailModal"

        :resident="selectedResident"

        @close="closeDetailModal"
    />

</div>

</template>

<script setup>

import { ref, onMounted } from 'vue'

import directoryService from '@/services/directory.service'

import DirectoryFilters from './components/DirectoryFilters.vue'

import DirectoryTable from './components/DirectoryTable.vue'

import DirectoryDetailModal
    from './components/DirectoryDetailModal.vue'

/**
 * State
 */

const loading = ref(false)

const residents = ref([])

const streets = ref([])

const hasSearched = ref(false)

const showDetailModal = ref(false)

const selectedResident = ref(null)

const pagination = ref({

    currentPage: 1,

    perPage: 5,

    total: 0,

    lastPage: 1
})

const filters = ref({

    owner_name: '',

    resident_name: '',

    lot: '',

    block: '',

    Id_street: '',

    status: ''
})

/**
 * Load streets
 */

async function loadStreets()
{
    try {

        const response =
            await directoryService.getStreets()

        streets.value =
            response.data

    } catch (error) {

        console.error(error)
    }
}

/**
 * Load Directory
 */

async function loadDirectory(page = 1)
{
    loading.value = true

    try {

        const response =
            await directoryService.searchResidents({

                page,

                perPage:
                    pagination.value.perPage,

                ...filters.value
            })

        residents.value =
            response.data

        pagination.value =
            response.pagination

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

function handleSearch(newFilters)
{
    filters.value = newFilters

    /**
     * Validate filters
     */

    const hasAnyFilter =
        Object.values(newFilters)
            .some(value => value)

    /**
     * No filters
     */

    if (!hasAnyFilter) {

        hasSearched.value = false

        residents.value = []

        return
    }

    hasSearched.value = true

    loadDirectory(1)
}

/**
 * Clear
 */

function clearFilters()
{
    filters.value = {

        owner_name: '',

        resident_name: '',

        lot: '',

        block: '',

        Id_street: '',

        status: ''
    }

    residents.value = []

    hasSearched.value = false
}

/**
 * Pagination
 */

function changePage(page)
{
    loadDirectory(page)
}

/**
 * Detail Modal
 */

function openDetailModal(resident)
{
    selectedResident.value = resident

    showDetailModal.value = true
}

function closeDetailModal()
{
    showDetailModal.value = false
}



/**
 * Has filters
 */

function hasFilters()
{
    return Object.values(

        filters.value

    ).some(value => value)
}

/**
 * Export CSV
 */

function handleExport()
{
    /**
     * Prevent export all table
     */

    if (!hasFilters()) {

        alert(
            'Apply filters before export'
        )

        return
    }

    directoryService.exportDirectory(
        filters.value
    )
}

/**
 * Init
 */

onMounted(async () => {

    await loadStreets()
})

</script>

<style scoped>

.directory-page {

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.empty-search-state {

    background: #fef2f2;

    border: 1px solid #fecaca;

    border-left: 6px solid #dc2626;

    border-radius: 14px;

    padding: 28px;

    text-align: center;

    color: #991b1b;

    font-size: 16px;

    font-weight: 600;

    letter-spacing: 0.2px;

    box-shadow:
        0 2px 10px rgba(220,38,38,0.08);
}

</style>