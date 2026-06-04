<template>

<div class="streets-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>

                Streets

            </h1>

            <p>

                Residential streets catalog

            </p>

        </div>

        <button
            class="btn-create"
            @click="openCreateModal"
        >

            + New Street

        </button>

    </div>

    <!-- Filters -->

    <StreetFilters
        :filters="filters"
        @search="handleSearch"
    />

    <!-- Empty State -->

    <div
        v-if="
            !initialized &&
            !loading
        "
        class="empty-state"
    >

        Search streets to display data

    </div>

    <!-- Table -->

    <StreetsTable
        v-else
        :loading="loading"
        :streets="streets"
        :pagination="pagination"
        @edit="openEditModal"
        @delete="handleDelete"
        @page-change="changePage"
    />

    <!-- Modal -->

    <StreetModal
        v-if="showModal"
        :street="selectedStreet"
        @close="closeModal"
        @saved="handleSaved"
    />

</div>

</template>

<script setup>

import {

    ref

} from 'vue'

import streetsService
from '@/services/streets.service'

import StreetsTable
from './components/StreetsTable.vue'

import StreetModal
from './components/StreetModal.vue'

import StreetFilters
from './components/StreetFilters.vue'

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const streets = ref([])

const loading = ref(false)

const showModal = ref(false)

const selectedStreet = ref(null)

/**
 * Lazy load control
 */

const initialized = ref(false)

/**
 * Pagination
 */

const pagination = ref({

    currentPage: 1,

    perPage: 5,

    total: 0,

    lastPage: 1
})

/**
 * Filters
 */

const filters = ref({

    search: ''
})

/*
|--------------------------------------------------------------------------
| Load Streets
|--------------------------------------------------------------------------
*/

async function loadStreets(page = 1) {

    loading.value = true

    try {

        const response =
            await streetsService.getStreets({

                page,

                perPage:
                    pagination.value.perPage,

                ...filters.value
            })

        streets.value =
            response.data

        pagination.value =
            response.pagination

        initialized.value = true

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
    }
}

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

function handleSearch(newFilters) {

    filters.value = newFilters

    loadStreets(1)
}

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

function changePage(page) {

    if (

        page < 1 ||

        page >
        pagination.value.lastPage

    ) {

        return
    }

    loadStreets(page)
}

/*
|--------------------------------------------------------------------------
| Create
|--------------------------------------------------------------------------
*/

function openCreateModal() {

    selectedStreet.value = null

    showModal.value = true
}

/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/

function openEditModal(street) {

    selectedStreet.value = street

    showModal.value = true
}

/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeModal() {

    showModal.value = false
}

/*
|--------------------------------------------------------------------------
| Saved
|--------------------------------------------------------------------------
*/

async function handleSaved() {

    closeModal()

    /**
     * Reload only if initialized
     */

    if (initialized.value) {

        await loadStreets(
            pagination.value.currentPage
        )
    }
}

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

async function handleDelete(street) {

    if (
        !confirm(
            `Delete street ${street.name}?`
        )
    ) {

        return
    }

    try {

        await streetsService.deleteStreet(

            street.Id_street
        )

        await loadStreets(

            pagination.value.currentPage
        )

    } catch (error) {

        console.error(error)
    }
}

</script>

<style scoped>

.streets-page {

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

/*
|--------------------------------------------------------------------------
| Empty State
|--------------------------------------------------------------------------
*/

.empty-state {

    background: white;

    border-radius: 14px;

    padding: 60px;

    text-align: center;

    color: #6b7280;

    font-size: 15px;

    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

</style>