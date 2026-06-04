<template>

<div class="table-container">

    <!-- Loading -->

    <div
        v-if="loading"
        class="loading-state"
    >

        Loading directory...

    </div>

    <template v-else>

        <!-- Table -->

        <table
            v-if="residents.length"
            class="directory-table"
        >

            <thead>

                <tr>

                    <th>

                        Casa

                    </th>

                    <th>

                        Calle

                    </th>

                    <th>

                        Residente

                    </th>

                    <th>

                        Teléfono

                    </th>

                    <th>

                        Estatus

                    </th>

                    <th>

                        Acción

                    </th>

                </tr>

            </thead>

            <tbody>

                <tr
                    v-for="resident in residents"
                    :key="resident.Id_resident"
                >

                    <!-- House -->

                    <td>

                        <div class="house-info">

                            <strong>

                                {{ resident.lot }}

                            </strong>

                            <small>

                                Block:
                                {{ resident.block }}

                            </small>

                        </div>

                    </td>

                    <!-- Street -->

                    <td>

                        {{ resident.street_name }}

                    </td>

                    <!-- Resident -->

                    <td>

                        <div class="resident-info">

                            <strong>

                                {{
                                    resident.resident_name
                                }}

                            </strong>

                            <small>

                                {{
                                    resident.owner_name
                                }}

                            </small>

                        </div>

                    </td>

                    <!-- Phone -->

                    <td>

                        {{
                            resident.phone_1 || '-'
                        }}

                    </td>

                    <!-- Status -->

                    <td>

                        <span
                            class="status-badge"
                            :class="resident.status"
                        >

                            {{ resident.status }}

                        </span>

                    </td>

                    <!-- Actions -->

                    <td>

                        <button
                            class="btn-detail"
                            @click="
                                $emit(
                                    'view',
                                    resident
                                )
                            "
                        >

                            Ver Detalle

                        </button>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- Empty -->

        <div
            v-else
            class="empty-state"
        >

            No residents found

        </div>

        <!-- Pagination -->

        <div
            v-if="
                pagination?.lastPage > 1
            "
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

    'page-change',

    'view'
])

function changePage(page) {

    emit(

        'page-change',

        page
    )
}

</script>

<style scoped>

.table-container {

    background: white;

    border-radius: 18px;

    padding: 22px;

    box-shadow:
        0 4px 14px rgba(0,0,0,0.05);
}

.loading-state,
.empty-state {

    padding: 50px;

    text-align: center;

    color: #6b7280;
}

.directory-table {

    width: 100%;

    border-collapse: collapse;
}

.directory-table th {

    text-align: left;

    padding: 14px;

    background: #f9fafb;

    color: #374151;

    font-size: 14px;

    font-weight: 700;
}

.directory-table td {

    padding: 16px 14px;

    border-bottom:
        1px solid #f3f4f6;
}

.house-info,
.resident-info {

    display: flex;

    flex-direction: column;

    gap: 4px;
}

.house-info small,
.resident-info small {

    color: #6b7280;
}

.status-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;
}

.status-badge.ACTIVE {

    background: #dcfce7;

    color: #166534;
}

.status-badge.INACTIVE {

    background: #fee2e2;

    color: #991b1b;
}

.btn-detail {

    border: none;

    background: #2563eb;

    color: white;

    padding: 10px 14px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;

    transition: 0.2s;
}

.btn-detail:hover {

    background: #1d4ed8;
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

    padding: 10px 16px;

    border-radius: 10px;

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

    .directory-table {

        min-width: 900px;
    }
}

</style>
