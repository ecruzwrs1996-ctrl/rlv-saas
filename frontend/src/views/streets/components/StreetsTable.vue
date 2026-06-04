<template>

<div class="table-container">

    <!-- Loading -->

    <div
        v-if="loading"
        class="loading-state"
    >

        Loading streets...

    </div>

    <template v-else>

        <!-- Table -->

        <table
            v-if="streets.length"
            class="streets-table"
        >

            <thead>

                <tr>

                    <th v-if="showIdColumn">ID</th>

                    <th>Street</th>

                    <th>Created At</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <tr
                    v-for="street in streets"
                    :key="street.Id_street"
                >

                    <td v-if="showIdColumn">

                        {{ street.Id_street }}

                    </td>

                    <td>

                        {{ street.name }}

                    </td>

                    <td>

                        {{ street.created_at }}

                    </td>

                    <td>

                        <div class="actions">

                            <button
                                class="btn-edit"
                                @click="
                                    $emit(
                                        'edit',
                                        street
                                    )
                                "
                            >

                                Edit

                            </button>

                            <button
                                class="btn-delete"
                                @click="
                                    $emit(
                                        'delete',
                                        street
                                    )
                                "
                            >

                                Delete

                            </button>

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- Empty -->

        <div
            v-else
            class="empty-state"
        >

            No streets found

        </div>

        <!-- Pagination -->

        <div
            v-if="pagination.lastPage > 1"
            class="pagination"
        >

            <button
                :disabled="
                    pagination.currentPage === 1
                "
                @click="
                    changePage(
                        pagination.currentPage - 1
                    )
                "
            >

                Prev

            </button>

            <span>

                Page
                {{ pagination.currentPage }}
                of
                {{ pagination.lastPage }}

            </span>

            <button
                :disabled="
                    pagination.currentPage ===
                    pagination.lastPage
                "
                @click="
                    changePage(
                        pagination.currentPage + 1
                    )
                "
            >

                Next

            </button>

        </div>

    </template>

</div>

</template>

<script setup>

defineProps({

    streets: {
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

    text-align: center;

    padding: 40px;

    color: #6b7280;
}

.streets-table {

    width: 100%;

    border-collapse: collapse;
}

.streets-table th {

    text-align: left;

    background: #f9fafb;

    padding: 14px;

    color: #374151;
}

.streets-table td {

    padding: 14px;

    border-bottom:
        1px solid #f3f4f6;
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

    .streets-table {

        min-width: 600px;
    }
}

</style>