<template>

<div class="table-container">

    <div
        v-if="loading"
        class="loading-state"
    >
        Loading residents...
    </div>

    <template v-else>

        <!-- Desktop Table -->

        <table
            v-if="residents.length"
            class="residents-table"
        >

            <thead>

                <tr>

                    <th v-if="showIdColumn">ID</th>

                    <th>Resident</th>

                    <th>Street</th>

                    <th>House</th>

                    <th>Status</th>

                    <th>Phone</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <tr
                    v-for="resident in residents"
                    :key="resident.Id_resident"
                >

                   <td v-if="showIdColumn">
                        {{ resident.Id_resident }}
                    </td>

                    <td>

                        <div class="resident-info">

                            <strong>
                                {{ resident.resident_name }}
                            </strong>

                            <small>
                                {{ resident.owner_name || 'No owner' }}
                            </small>

                        </div>

                    </td>

                    <td>

                        {{ resident.street_name }}

                    </td>

                    <td>

                        {{ resident.house_number }}

                    </td>

                    <td>

                        <span
                            class="status-badge"
                            :class="resident.status"
                        >
                            {{ resident.status }}
                        </span>

                    </td>

                    <td>

                        {{ resident.phone_1 || '-' }}

                    </td>

                    <td>

                        <div class="actions">

                            <button
                                class="btn-edit"
                                @click="$emit('edit', resident)"
                            >
                                Edit
                            </button>

                            <button
                                class="btn-delete"
                                @click="$emit('delete', resident)"
                            >
                                Delete
                            </button>

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- Empty State -->

        <div
            v-else
            class="empty-state"
        >

            No residents found

        </div>

        <!-- Pagination -->

        <div
            v-if="pagination.lastPage > 1"
            class="pagination"
        >

            <button
                :disabled="pagination.currentPage === 1"
                @click="changePage(
                    pagination.currentPage - 1
                )"
            >
                Prev
            </button>

            <span>

                Page {{ pagination.currentPage }}
                of {{ pagination.lastPage }}

            </span>

            <button
                :disabled="
                    pagination.currentPage ===
                    pagination.lastPage
                "
                @click="changePage(
                    pagination.currentPage + 1
                )"
            >
                Next
            </button>

        </div>

    </template>

</div>

</template>

<script setup>

defineProps({

    residents: {
        type: Array,
        default: () => []
    },

    loading: {
        type: Boolean,
        default: false
    },

    pagination: {
        type: Object,
        required: true
    }
})

const emit = defineEmits([

    'edit',
    'delete',
    'page-change'
])

function changePage(page) {

    emit('page-change', page)
}

</script>

<style scoped>

.table-container {

    background: white;
    border-radius: 14px;
    padding: 20px;
    box-shadow:
        0 2px 10px rgba(0,0,0,0.05);
}

.loading-state,
.empty-state {

    padding: 40px;
    text-align: center;
    color: #6b7280;
}

.residents-table {

    width: 100%;
    border-collapse: collapse;
}

.residents-table th {

    text-align: left;
    padding: 14px;
    background: #f9fafb;
    font-size: 14px;
    color: #374151;
}

.residents-table td {

    padding: 14px;
    border-bottom: 1px solid #f3f4f6;
}

.resident-info {

    display: flex;
    flex-direction: column;
    gap: 4px;
}

.resident-info small {

    color: #6b7280;
}

.status-badge {

    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.ACTIVE {

    background: #dcfce7;
    color: #166534;
}

.status-badge.INACTIVE {

    background: #fee2e2;
    color: #991b1b;
}

.actions {

    display: flex;
    gap: 10px;
}

.btn-edit,
.btn-delete {

    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
}

.btn-edit {

    background: #2563eb;
    color: white;
}

.btn-delete {

    background: #dc2626;
    color: white;
}

.pagination {

    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.pagination button {

    border: none;
    background: #111827;
    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
}

.pagination button:disabled {

    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {

    .table-container {

        overflow-x: auto;
    }

    .residents-table {

        min-width: 800px;
    }
}

</style>