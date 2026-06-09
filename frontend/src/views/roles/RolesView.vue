<template>

<div class="roles-page">

    <!-- Header -->

    <div class="page-header">

        <div>

            <h1>

               Set Up General

            </h1>

            <p>

                Manage Roles

            </p>

        </div>

        <button
            class="btn-create"
            @click="openCreate"
        >

            Create Role

        </button>

    </div>

    <!-- Loading -->

    <div
        v-if="loading"
        class="loading-state"
    >

        Loading roles...

    </div>

    <!-- Table -->

    <table
        v-else
        class="roles-table"
    >

        <thead>

            <tr>

                <th v-if="showIdColumn">ID</th>

                <th>Name</th>

                <th>Description</th>

                <th>Status</th>

                <th>Created</th>

                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <tr
                v-for="role in roles"
                :key="role.Id_role"
            >

                <td v-if="showIdColumn">

                    {{ role.Id_role }}

                </td>

                <td>

                    {{ role.name }}

                </td>

                <td>

                    {{ role.description }}

                </td>

                <td>

                    {{ role.status }}

                </td>

                <td>

                    {{ role.created_at }}

                </td>

                <td class="actions">

                    <button
                        class="btn-edit"
                        @click="editRole(role)"
                    >

                        Edit

                    </button>

                    <button
                        class="btn-delete"
                        @click="deleteRole(role)"
                    >

                        Delete

                    </button>

                </td>

            </tr>

        </tbody>

    </table>

    <!-- Modal -->

    <RolesFormModal

        :visible="showModal"

        :role="selectedRole"

        @close="
            showModal = false
        "

        @save="saveRole"
    />

</div>

</template>

<script setup>

import {

    ref,

    onMounted

} from 'vue'

import rolesService
    from '@/services/roles.service'

import RolesFormModal
from './components/RolesFormModal.vue'

/**
 * State
 */

const loading =
    ref(false)

const roles =
    ref([])

const showModal =
    ref(false)

const selectedRole =
    ref(null)

/**
 * Load Roles
 */

async function loadRoles()
{
    loading.value = true

    try {

        const response =
            await rolesService
                .getRoles()

        roles.value =
            response.data

    } catch (error) {

        console.error(error)
    }

    finally {

        loading.value = false
    }
}

/**
 * Create
 */

function openCreate()
{
    selectedRole.value = null

    showModal.value = true
}

/**
 * Edit
 */

function editRole(role)
{
    selectedRole.value = role

    showModal.value = true
}

/**
 * Delete
 */

async function deleteRole(role)
{
    const confirmed =
        confirm(

            `Delete role ${role.name}?`
        )

    if (!confirmed) {

        return
    }

    try {

        await rolesService
            .deleteRole(
                role.Id_role
            )

        await loadRoles()

    } catch (error) {

        console.error(error)
    }
}

/**
 * Save
 */

async function saveRole(data)
{
    try {

        /**
         * UPDATE
         */
        if (
            selectedRole.value
        ) {

            await rolesService
                .updateRole(

                    selectedRole.value.Id_role,

                    data
                )
        }

        /**
         * CREATE
         */
        else {

            await rolesService
                .createRole(data)
        }

        showModal.value = false

        await loadRoles()

    } catch (error) {

        console.error(error)
    }
}

/**
 * Init
 */

onMounted(() => {

    loadRoles()
})

</script>

<style scoped>

.roles-page {

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

    border: none;

    background: #111827;

    color: white;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;
}

.loading-state {

    background: white;

    padding: 40px;

    border-radius: 14px;

    text-align: center;
}

.roles-table {

    width: 100%;

    border-collapse: collapse;

    background: white;

    border-radius: 14px;

    overflow: hidden;
}

.roles-table th {

    background: #f9fafb;

    text-align: left;

    padding: 14px;
}

.roles-table td {

    padding: 14px;

    border-bottom:
        1px solid #f3f4f6;
}

.actions {

    display: flex;

    gap: 10px;
}

.btn-edit {

    border: none;

    background: #2563eb;

    color: white;

    padding: 8px 12px;

    border-radius: 8px;

    cursor: pointer;
}

.btn-delete {

    border: none;

    background: #dc2626;

    color: white;

    padding: 8px 12px;

    border-radius: 8px;

    cursor: pointer;
}

</style>
