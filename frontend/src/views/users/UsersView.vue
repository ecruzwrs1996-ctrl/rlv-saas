<template>

<div class="users-page">

    <!-- Header -->

    <div class="header">

        <div>

            <h1>
                Users
            </h1>

            <p>
                Enterprise users management
            </p>

        </div>

        <button
            class="btn-create"
            @click="openCreateModal"
        >
            + New User
        </button>

    </div>

    <!-- Filters -->

    <div class="filters-card">

        <input
            v-model="filters.search"
            type="text"
            placeholder="Search username..."
            @keyup.enter="handleSearch"
        />

        <select v-model="filters.role">

            <option value="">
                All Roles
            </option>

            <option value="1">
                SYS
            </option>

            <option value="2">
                ADM
            </option>

            <option value="3">
                GUA
            </option>

        </select>

        <button @click="handleSearch">

            Search

        </button>

        <button
            class="btn-clear"
            @click="clearFilters"
        >
            Clear
        </button>

    </div>

    <!-- Empty State -->

    <div
        v-if="!users.length && !loading"
        class="empty-state"
    >

        No users loaded

    </div>

    <!-- Table -->

    <UsersTable

        v-if="users.length"

        :users="users"

        @edit="editUser"

        @delete="deleteUser"
    />

    <!-- Pagination -->

    <div
        v-if="users.length"
        class="pagination"
    >

        <button
            @click="changePage(currentPage - 1)"
            :disabled="currentPage <= 1"
        >
            Previous
        </button>

        <span>

            Page {{ currentPage }}

        </span>

        <button
            @click="changePage(currentPage + 1)"
            :disabled="currentPage >= lastPage"
        >
            Next
        </button>

    </div>

    <!-- Modal -->

    <UserModal

        v-if="showModal"

        :user="selectedUser"

        @close="closeModal"

        @saved="handleSaved"
    />

</div>

</template>

<script setup>

import { ref } from 'vue'

import usersService
from '@/services/users.service'

import UsersTable
from '@/components/users/UsersTable.vue'

import UserModal
from '@/components/users/UserModal.vue'

const users = ref([])

const loading = ref(false)

const currentPage = ref(1)

const lastPage = ref(1)

const showModal = ref(false)

const selectedUser = ref(null)

const filters = ref({

    search: '',

    role: ''
})

/**
 * Load Users
 */

const loadUsers = async (
    page = 1
) => {

    loading.value = true

    try {

        const response =
            await usersService.getUsers({

                page,

                perPage: 5,

                search:
                    filters.value.search,

                role:
                    filters.value.role
            })

        users.value =
            response.data

        lastPage.value =
            response.pagination.lastPage

        currentPage.value =
            response.pagination.currentPage

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
    }
}

/**
 * Search
 */

const handleSearch = () => {

    loadUsers(1)
}

/**
 * Clear
 */

const clearFilters = () => {

    filters.value = {

        search: '',

        role: ''
    }

    users.value = []
}

/**
 * Pagination
 */

const changePage = (
    page
) => {

    loadUsers(page)
}

/**
 * Create
 */

const openCreateModal = () => {

    selectedUser.value = null

    showModal.value = true
}

/**
 * Edit
 */

const editUser = (
    user
) => {

    selectedUser.value = user

    showModal.value = true
}

/**
 * Close
 */

const closeModal = () => {

    showModal.value = false
}

/**
 * Reload
 */

const handleSaved = () => {

    closeModal()

    loadUsers(currentPage.value)
}

/**
 * Delete
 */

const deleteUser = async (
    user
) => {

    if (
        !confirm(
            `Delete ${user.username}?`
        )
    ) {

        return
    }

    try {

        await usersService.deleteUser(
            user.Id_user
        )

        loadUsers(currentPage.value)

    } catch (error) {

        console.error(error)
    }
}

</script>

<style scoped>

.users-page {

    display: flex;

    flex-direction: column;

    gap: 20px;
}

.header {

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.filters-card {

    display: flex;

    gap: 12px;

    background: white;

    padding: 20px;

    border-radius: 14px;

    box-shadow:
        0 2px 8px rgba(0,0,0,.05);
}

.filters-card input,
.filters-card select {

    padding: 10px 14px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    min-width: 220px;
}

.filters-card button {

    padding: 10px 16px;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    background: #111827;

    color: white;
}

.btn-clear {

    background: #6b7280 !important;
}

.btn-create {

    background: #111827;

    color: white;

    border: none;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;
}

.pagination {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 15px;
}

.pagination button {

    padding: 10px 16px;

    border: none;

    border-radius: 8px;

    background: #111827;

    color: white;

    cursor: pointer;
}

.empty-state {

    background: white;

    padding: 60px;

    border-radius: 14px;

    text-align: center;

    color: #6b7280;

    box-shadow:
        0 2px 8px rgba(0,0,0,.05);
}

</style>