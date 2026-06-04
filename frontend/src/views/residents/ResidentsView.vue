<template>

<div class="residents-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>
                Residents
            </h1>

            <p>
                Residential administration module
            </p>

        </div>

        <button
            class="btn-create"
            @click="openCreateModal"
        >

            + New Resident

        </button>

    </div>

    <!-- Filters -->

    <ResidentFilters
        :filters="filters"
        :streets="streets"
        @search="handleSearch"
    />

    <!-- Table -->

    <ResidentsTable
        :loading="loading"
        :residents="residents"
        :pagination="pagination"
        @edit="openEditModal"
        @delete="handleDelete"
        @page-change="changePage"
    />

    <!-- Empty State -->

    <div
        v-if="
            !loading &&
            searched &&
            residents.length === 0
        "
        class="empty-state"
    >

        No residents found

    </div>

    <!-- Modal -->

    <ResidentModal
        v-if="showModal"
        :resident="selectedResident"
        :streets="streets"
        @close="closeModal"
        @saved="handleSaved"
    />

</div>

</template>

<script setup>

import {

    ref,
    onMounted

} from 'vue'

import residentsService
from '@/services/residents.service'

import ResidentsTable
from './components/ResidentsTable.vue'

import ResidentModal
from './components/ResidentModal.vue'

import ResidentFilters
from './components/ResidentFilters.vue'

const residents = ref([])

const streets = ref([])

const loading = ref(false)

const searched = ref(false)

const showModal = ref(false)

const selectedResident = ref(null)

const pagination = ref({

    currentPage: 1,

    perPage: 5,

    total: 0,

    lastPage: 1
})

const filters = ref({

    resident_name: '',

    owner_name: '',

    Id_street: '',

    status: ''
})

/**
 * Load residents
 */

async function loadResidents(page = 1) {

    loading.value = true

    try {

        const response =
            await residentsService.getResidents({

                page,

                perPage:
                    pagination.value.perPage,

                ...filters.value
            })

        residents.value =
            response.data

        pagination.value =
            response.pagination

        searched.value = true

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
    }
}

/**
 * Load streets
 */

async function loadStreets() {

    try {

        const response =
            await residentsService.getStreets()

        streets.value =
            response.data

    } catch (error) {

        console.error(error)
    }
}

/**
 * Search
 */

function handleSearch(newFilters) {

    filters.value = newFilters

    pagination.value.currentPage = 1

    loadResidents(1)
}

/**
 * Pagination
 */

function changePage(page) {

    loadResidents(page)
}

/**
 * Create
 */

function openCreateModal() {

    selectedResident.value = null

    showModal.value = true
}

/**
 * Edit
 */

function openEditModal(resident) {

    selectedResident.value = resident

    showModal.value = true
}

/**
 * Close modal
 */

function closeModal() {

    showModal.value = false
}

/**
 * Saved
 */

async function handleSaved() {

    closeModal()

    if (searched.value) {

        await loadResidents(
            pagination.value.currentPage
        )
    }
}

/**
 * Delete
 */

async function handleDelete(resident) {

    if (

        !confirm(

            `Delete resident ${resident.resident_name}?`
        )
    ) {

        return
    }

    try {

        await residentsService.deleteResident(

            resident.Id_resident
        )

        await loadResidents(

            pagination.value.currentPage
        )

    } catch (error) {

        console.error(error)
    }
}

/**
 * Mounted
 */

onMounted(async () => {

    await loadStreets()
})

</script>

<style scoped>

.residents-page {

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.btn-create {

    background: #111827;

    color: white;

    border: none;

    padding: 10px 18px;

    border-radius: 8px;

    cursor: pointer;
}

.empty-state {

    background: white;

    padding: 40px;

    border-radius: 12px;

    text-align: center;

    color: #6b7280;

    font-size: 15px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

</style>