<template>

<div class="table-container">

    <!-- Top Actions -->

    <div class="table-actions">

        <button
            class="btn-export"
            @click="$emit('export')"
        >

            Audit Export

        </button>

        <button
            v-if="
                user?.Role_id == 1
            "
            class="btn-purge"
            @click="handlePurge"
        >

            Audit Purgin Process

        </button>

    </div>

    <!-- Loading -->

    <div
        v-if="loading"
        class="loading-state"
    >

        Loading audit logs...

    </div>

    <template v-else>

        <!-- Table -->

        <table
            v-if="logs.length"
            class="audit-table"
        >

            <thead>

                <tr>

                    <th>User</th>

                    <th>Role</th>

                    <th>Module</th>

                    <th>Action</th>

                    <th>Description</th>

                    <th>Login</th>

                    <th>Logout</th>

                    <th>Created At</th>

                </tr>

            </thead>

            <tbody>

                <tr
                    v-for="log in logs"
                    :key="log.Id_aud_action"
                >

                    <!-- User -->

                    <td>

                        <div class="user-info">

                            <strong>

                                {{ log.username }}

                            </strong>

                            <small>

                                {{ log.name }}

                            </small>

                        </div>

                    </td>

                    <!-- Role -->

                    <td>

                        <span
                            class="role-badge"
                        >

                            {{ getRoleName(
                                log.Role_id
                            ) }}

                        </span>

                    </td>

                    <!-- Module -->

                    <td>

                        {{ log.table_name || '-' }}

                    </td>

                    <!-- Action -->

                    <td>

                        <span
                            class="action-badge"
                            :class="
                                getActionClass(
                                    log.action_type
                                )
                            "
                        >

                            {{ log.action_type || '-' }}

                        </span>

                    </td>

                    <!-- Description -->

                    <td>

                        {{ log.description || '-' }}

                    </td>

                    <!-- Login -->

                    <td>

                        {{ log.login_at || '-' }}

                    </td>

                    <!-- Logout -->

                    <td>

                        {{ log.logout_at || '-' }}

                    </td>

                    <!-- Created -->

                    <td>

                       {{ log.created_at || '-' }}

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- Empty -->

        <div
            v-else
            class="empty-state"
        >

            No audit logs found

        </div>

        <!-- Pagination -->

        <div
            v-if="pagination.totalPages > 1"
            class="pagination"
        >

            <button
                :disabled="
                    pagination.page === 1
                "
                @click="
                    changePage(
                        pagination.page - 1
                    )
                "
            >

                Prev

            </button>

            <span>

                Page {{ pagination.page }}
                of {{ pagination.totalPages }}

            </span>

            <button
                :disabled="
                    pagination.page ===
                    pagination.totalPages
                "
                @click="
                    changePage(
                        pagination.page + 1
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

import authService from '@/services/auth.service'


const props = defineProps({

    logs: {
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
    },

    roles: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits([

    'page-change',
    'export',
    'purge'
])

const user =
    authService.getUser()

function changePage(page) {

    emit(
        'page-change',
        page
    )
}

function handlePurge() {

    if (

        !confirm(
            '¿Ejecutar depuración auditoría?'
        )
    ) {

        return
    }

    emit('purge')
}

function getRoleName(roleId) {

    const role = props.roles.find(

        item => Number(item.Id_role) === Number(roleId)
    )

    return role
        ? role.name
        : 'UNKNOWN'
}

function getActionClass(action) {

    switch (action) {

        case 'CREATE':
            return 'success'

        case 'UPDATE':
            return 'warning'

        case 'DELETE':
            return 'danger'

        case 'LOGIN':
            return 'primary'

        case 'LOGOUT':
            return 'secondary'

        default:
            return 'default'
    }
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

.table-actions {

    display: flex;

    justify-content: flex-end;

    gap: 14px;

    margin-bottom: 20px;
}

.btn-export,
.btn-purge {

    border: none;

    padding: 12px 18px;

    border-radius: 10px;

    cursor: pointer;

    font-weight: 600;
}

.btn-export {

    background: #2563eb;

    color: white;
}

.btn-purge {

    background: #dc2626;

    color: white;
}

.loading-state,
.empty-state {

    padding: 40px;

    text-align: center;

    color: #6b7280;
}

.audit-table {

    width: 100%;

    border-collapse: collapse;
}

.audit-table th {

    text-align: left;

    padding: 14px;

    background: #f9fafb;

    font-size: 14px;

    color: #374151;
}

.audit-table td {

    padding: 14px;

    border-bottom:
        1px solid #f3f4f6;
}

.user-info {

    display: flex;

    flex-direction: column;

    gap: 4px;
}

.user-info small {

    color: #6b7280;
}

.role-badge {

    background: #e5e7eb;

    color: #111827;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;
}

.action-badge {

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;
}

.success {

    background: #dcfce7;

    color: #166534;
}

.warning {

    background: #fef3c7;

    color: #92400e;
}

.danger {

    background: #fee2e2;

    color: #991b1b;
}

.primary {

    background: #dbeafe;

    color: #1d4ed8;
}

.secondary {

    background: #e5e7eb;

    color: #374151;
}

.default {

    background: #f3f4f6;

    color: #111827;
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

    .audit-table {

        min-width: 1200px;
    }

    .table-actions {

        flex-direction: column;
    }
}

</style>